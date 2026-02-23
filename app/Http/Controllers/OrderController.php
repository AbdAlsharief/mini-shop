<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function myOrders()
    {
        $orders = Auth::user()
            ->orders()
            ->latest()
            ->get();

        return view('orders.my-orders', compact('orders'));
    }

    public function show(Order $order)
    {
    if($order->user_id != Auth::id()){
        abort(403);
    }
    $order->load('items.product');
    return view('orders.show', compact('order'));
    }
}
