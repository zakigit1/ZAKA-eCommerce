<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;

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


    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function transaction(){
        return $this->hasOne(Transaction::class,'order_id','id');
    }

    public function orderProducts(){
        return $this->hasMany(OrderProduct::class,'order_id','id');
    }
}
