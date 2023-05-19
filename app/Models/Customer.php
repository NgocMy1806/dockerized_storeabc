<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'email',
        'cognito_id',
        'email_verified_at',
        'password',
        'country_id',
        'state_id',
        'city_id',
        'address_bottom',
        'rememberToken', 
    ];
    public function orders()
{
    return $this->hasMany(Order::class, 'customer_id');
}
public function country()
{
    return $this->belongsTo(Country::class);
}
}
