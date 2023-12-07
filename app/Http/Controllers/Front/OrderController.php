<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrdersDetail;
use Auth;


class OrderController extends Controller
{
    public function orders($id = null)
    {
        if (empty($id)) {
            $orders = Order::with('orders_detail')->where('user_id', Auth::user()->id)->orderBy('id', 'Desc')->get()->toArray();
            return view('front.orders.orders')->with(compact('orders'));
        } else {
            $orderDetails = Order::with('orders_detail')->where('id', $id)->first()->toArray();
            return view('front.orders.order_details')->with(compact('orderDetails'));
        }
    }

    public function callback(Request $req)
    {
        $order_id  = $req->order_id;
        if ($req->status_code == 200) {
            $is_done = true;
        } else {
            $is_done = false;
        }
        \DB::table('order_callback')->insert([
            'order_id' => $order_id,
            'is_done' => $is_done,
            'response' => json_encode($req->all())
        ]);
        Order::where('id', $order_id)->update([
            'payment_method' => @$req->card_type ?? null,
            'order_status' => 'Lunas'
        ]);
        return response(['message' => 'Callback OK', 'data' => $req->all()]);
    }
}
