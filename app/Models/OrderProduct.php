<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
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
        'created_at',
        'updated_at'
    ];

    public function vendor(){
        return $this->belongsTo(Vendor::class,'vendor_id','id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }



}
