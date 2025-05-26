<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Services\CreateSnapTokenService;

class MidtransController extends Controller
{
    public function getSnapToken(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $product = Product::findOrFail($request->product_id);

        $orderId = 'BOOTCAMP-' . strtoupper(Str::random(10));

        $transaction = [
            'order_id' => $orderId,
            'gross_amount' => $product->price,
            'first_name' => $request->name,
            'email' => $request->email,
        ];

        $midtrans = new CreateSnapTokenService($transaction);
        $snapToken = $midtrans->getSnapToken();

        return response()->json([
            'snap_token' => $snapToken,
        ]);
    }
}
