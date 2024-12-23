<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{

    protected $table = "order_products";

    protected $fillable = [
        'order_id',
        'product_id',
        'vendor_id',
        'product_name',
        'unit_price',
        'qty',
        'variants',
        'variant_total',
        
    ];
    protected $hidden = [
        // 'created_at',
        // 'updated_at'
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class,'vendor_id','id');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id','id','id');
    }



}
