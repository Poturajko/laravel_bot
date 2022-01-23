<?php

namespace App\Http\Controllers;

use App\Events\OrderStore;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function store(Order $order, Request $request)
    {
        $secret = base64_encode(md5(uniqid("",true)));
        $order = $order->create([
            'name' => $request->input('name'),
            'email' => $request->input('email2'),
            'product' => $request->input('product'),
            'secret_key' => $secret,
        ]);

        event(new OrderStore($order));

        return response()->redirectTo('/');
    }
}
