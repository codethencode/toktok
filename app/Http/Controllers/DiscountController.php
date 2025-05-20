<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
class DiscountController extends Controller
{
    public function applyDiscount(Request $request)
    {
        $code = strtoupper($request->input('code'));

        $discount = Discount::where('code', $code)->first();

        if ($discount) {
            return response()->json([
                'success' => true,
                'discount' => $discount->percentage,
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }
}
