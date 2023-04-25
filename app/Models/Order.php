<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'total_amount',
        'order_status',
        'payment_status',
        'transaction_id',
        'is_pickup',
        'payment_method',
        'country_id',
        'state_id',
        'city_id',
        'address_bottom',
    ];

    // const PENDING='pending';
    // const PROCESSING='processing';
    // const COMPLETE='complete';
    const PENDING='pending';
    const PROCESSING='processing';
    const COMPLETED='completed';


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
