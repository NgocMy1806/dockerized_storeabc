<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use App\Models\Media;
use App\Services\TagService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class OrderService 

{
public function getOrders(){
    
    return Order::with('customer')->orderby('created_at', 'DESC')->paginate(10);
}

public function getOrderDetail($id)
{
    return $order = Order::with('orderDetails')->find($id);
  
}


public function changePaymentStatus($id, $payment_status){
    $order= Order::find($id);
    $order->update([
        'payment_status'=> $payment_status
    ]);
    return true;
}
public function changeOrderStatus($id, $order_status){
    $order= Order::find($id);
    $order->update([
        'order_status'=> $order_status
    ]);
    return true;
}

}