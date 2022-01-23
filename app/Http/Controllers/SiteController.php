<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $orders = Order::active()->get();

        return view('site.order', ['orders' => $orders]);
    }
}
