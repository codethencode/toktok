<?php

namespace App\Http\Controllers;

use App\Models\DossierCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PondUploadController extends Controller
{
    public function store(Request $request, $directory)
    {

        $isEditable = DossierCustomer::where('directory_id',$directory)->first();
        $canEdit = (!$isEditable) ? 'yes' : ($isEditable->validSend === 'validSent' ? 'no' : 'yes');

        if($canEdit==='no') {
            return response()->json(['path' => '', 'message' => 'Erreur!'], 404);
        }
        else {

            // Validation du fichier
            $request->validate([
                'file' => 'required|file|max:300720', // max 10MB
            ]);

            $file = $request->file('file');
            // Obtenez le nom original du fichier
            $originalName = $file->getClientOriginalName();

            // Transformez le nom du fichier
            $sanitizedFileName = $this->sanitizeFileName($originalName);

            //$filename = strtolower(trim(preg_replace('/[^A-Za-z0-9-]/', '-', $file->getClientOriginalName())));
            $path = $file->storeAs($directory . '/', $sanitizedFileName, 'public');
            $updateBdd = $this->updateBdd($directory);

            $path = str_replace('/storage/', '', $directory) . '/' . $sanitizedFileName;

            // Stockage du fichier
            // $path = $request->file('file')->store($directory, 'public');
            // Retourner la réponse

            return response()->json(['path' => $path, 'message' => 'Fichier téléchargé avec succès!'], 200);
        }
    }

    public function index($directory, $canEdit)
    {
        $files = Storage::disk('public')->files($directory);
        return view('partials.file-list', compact('files', 'canEdit'))->render();
    }

    public function delete(Request $request)
    {
        $filePath = str_replace('/storage/','',$request->input('path'));

        $isEditable = DossierCustomer::where('directory_id',$request->input('directory'))->first();
        $canEdit = (!$isEditable) ? 'yes' : ($isEditable->validSend === 'validSent' ? 'no' : 'yes');

        if($canEdit==='no') {
            return response()->json(['path' => '', 'message' => 'Erreur!'], 404);
        }
        else {

            Log::info($filePath);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
                return response()->json(['status' => 'success', 'message' => 'Fichier supprimé avec succès']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Fichier non trouvé']);
    }


    public function revert(Request $request)
    {
        // Décodage de la chaîne JSON en tableau associatif
        $data = json_decode($request->getContent(), true);

        Log::info($data);

        // Vérifiez si le décodage a réussi et si le champ 'path' existe
        if (isset($data['path'])) {
            // Récupération du chemin
            $path = $data['path'];
            Storage::disk('public')->delete($path);
            Log::info('Reverted path: ' .$path);
        } else {
            Log::info('Erreur Reverted path');
        }
        Storage::disk('public')->delete($request->getContent());
        //  $path = 'public' . $request->getContent();
        //  Storage::delete($path);
        Log::info('Reverted path: ' . $request->getContent());
    }

    private function sanitizeFileName($filename)
    {
        // Mettre en minuscules
        $filename = strtolower($filename);

        // Remplacer les accents par leurs équivalents non accentués
        $filename = $this->removeAccents($filename);

        // Remplacer les apostrophes et les underscores par des tirets
        $filename = str_replace(['\'', '_'], '-', $filename);

        // Remplacer tous les caractères non-alphanumériques (hors points pour l'extension) par des tirets
        $filename = preg_replace('/[^a-z0-9\.]+/', '-', $filename);

        // Supprimer les tirets multiples et les tirets au début ou à la fin du nom
        $filename = trim(preg_replace('/-+/', '-', $filename), '-');

        return $filename;
    }

    private function removeAccents($string)
    {
        return strtr($string, [
            'à' => 'a', 'â' => 'a', 'ä' => 'a',
            'ç' => 'c',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'î' => 'i', 'ï' => 'i',
            'ô' => 'o', 'ö' => 'o',
            'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ÿ' => 'y',
            'À' => 'a', 'Â' => 'a', 'Ä' => 'a',
            'Ç' => 'c',
            'É' => 'e', 'È' => 'e', 'Ê' => 'e', 'Ë' => 'e',
            'Î' => 'i', 'Ï' => 'i',
            'Ô' => 'o', 'Ö' => 'o',
            'Ù' => 'u', 'Û' => 'u', 'Ü' => 'u',
            'Ÿ' => 'y',
        ]);
    }


    private function updateBdd($directory){

        $orderId = substr($directory, -11);
        Log::info($orderId);

        $exists = DossierCustomer::where('order_id', $orderId)->exists();

        $rep = storage_path('app/public/'.$directory); // Remplace par le chemin du dossier

        // Récupère tous les fichiers dans le dossier
        $files = File::files($rep);

        // Compte le nombre de fichiers
        $fileCount = count($files);

        Log::info($fileCount.'- Exists : '.$exists);

        if ($exists) {
            // L'enregistrement existe
            $dossier = DossierCustomer::where('order_id', $orderId)->first();
            $dossier->numberOfFiles = $fileCount;
            $dossier->save(); // Sauvegarde les changements dans la base de données
        } else {
            // L'enregistrement n'existe pas
            $user = DossierCustomer::create([
                'order_id' => $orderId,
                'user_id' => Auth::user()->id,
                'directory_id' => $directory,
                'numberOfFiles' => $fileCount,
                'validSend' => 'notSent',
                'dateValidSend' => '',
                'trackingShip' => '',
                'shipDate' => '',
                'infoDossier' => '',
            ]);
        }



//        $table->foreignId('order_id')->constrained('baskets');
//        $table->string('directory_id');
//        $table->integer('numberOfFiles')->default(0);
//        $table->string('validSend')->default('notSent');
//        $table->dateTime('dateValidSend');
//        $table->string('step')->default('envoiFichier-01');
//        $table->string('trackingShip');
//        $table->dateTime('shipDate');
//        $table->string('shipAddress');
//        $table->string('contactTel');
//        $table->string('contactName');
//        $table->string('contactMail');
//        $table->text('infoDossier');
    }

//$user = User::create([
//'name' => $request->name,
//'email' => $request->email,
//'password' => Hash::make($request->password),
//'phone' => $request->phone,
//'role' => 'customer',
//]);

}
