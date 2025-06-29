<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OptionPrice;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminController extends Controller
{
    public function clients(Request $request)
    {
        $rawUsers = User::with('baskets')->get();

        $transformed = $rawUsers->map(function ($user) {
            $paid = $user->baskets->where('isPaid', 'ok');
            $unpaid = $user->baskets->where('isPaid', 'ko');
            $abo = $user->baskets->where('isAbo', 'abo');

            return [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'is_google' => $user->registered_with_google,
                'paid_count' => $paid->count(),
                'paid_total' => $paid->sum('total_price'),
                'unpaid_count' => $unpaid->count(),
                'abo_count' => $abo->count(),
            ];
        });

        $totalCA = $transformed->sum('paid_total');

        $page = $request->get('page', 1);
        $perPage = 20;
        $clients = new LengthAwarePaginator(
            $transformed->forPage($page, $perPage),
            $transformed->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.clients', compact('clients', 'totalCA'));
    }


    public function options()
    {
        $options = OptionPrice::orderBy('categorie')->orderBy('label')->get()->groupBy('categorie');
        $allCategories = OptionPrice::select('categorie')->distinct()->pluck('categorie');
        $allDiscounts =  Discount::orderBy('percentage', 'asc')->get();
        return view('admin.options', compact('options', 'allCategories','allDiscounts'));
    }

    public function updateOptions(Request $request, $categorie)
    {
        $items = $request->input('items', []);

        foreach ($items as $id => $fields) {
            OptionPrice::where('id', $id)->update([
                'label' => $fields['label'],
                'description' => $fields['description'],
                'price' => $fields['price'],
            ]);
        }

        return redirect()->back()->with('success', "Catégorie '$categorie' mise à jour avec succès.");
    }

    public function createZone(Request $request)
    {
    $request->validate([
        'categorie' => 'required|string|max:255',
        'label' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
        'price' => 'required|numeric',
    ]);

    // Récupérer les deux derniers codes de la catégorie
    $lastOption = OptionPrice::where('categorie', $request->categorie)
                    ->whereNotNull('code')
                    ->orderByDesc('id')
                    ->first();

    $newCode = '00'; // code par défaut

    if ($lastOption && preg_match('/(\d{2})$/', $lastOption->code, $matches)) {
        $lastNumber = intval($matches[1]);
        $newCode = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
    }

    $fullCode = strtoupper($request->category) . '-' . $newCode;

    OptionPrice::create([
        'categorie' => $request->categorie,
        'label' => $request->label,
        'description' => $request->description,
        'price' => $request->price,
        'code' => $fullCode,
    ]);

    return redirect()->route('admin.options')->with('success', 'Nouvelle zone ajoutée avec succès.');
    }

    public function deleteZone($id)
    {
        OptionPrice::where('id', $id)->delete();

        return redirect()->route('admin.options')->with('success', 'Zone supprimée avec succès.');
    }
}

