<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = [
        'invoice_id',
        'user_id',
        'sub_total',
        'amount',
        'currency_name',
        'currency_icon',
        'product_qty',
        'payment_method',  
        'payment_status',
        'order_address',
        'shipping_method',
        'coupon',
        'order_status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
