<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

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
        // 'created_at',
        // 'updated_at'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class,'order_id','id');
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class,'order_id','id');
    }
}
