<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrdersDetail;
use Auth;


class OrderController extends Controller
{
    public function orders($id=null){
        if(empty($id)){
            $orders = Order::with('orders_detail')->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
            return view('front.orders.orders')->with(compact('orders'));    
        }else {
            $orderDetails = Order::with('orders_detail')->where('id',$id)->first()->toArray();        
            return view('front.orders.order_details')->with(compact('orderDetails'));
        }       
    }
   
}
