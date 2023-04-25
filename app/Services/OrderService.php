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

class OrderService extends BaseService

{
public function getOrders(){
    return Order::with('customer')->get();
}

}