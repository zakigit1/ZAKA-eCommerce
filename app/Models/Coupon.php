<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    protected $table ='coupons';

    protected $guarded =[
        'id',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];

    // protected $casts = [
    //     'status'=> 'boolean',
    // ]
    
    // public $timestamps = false;

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }

    // public function users()
    // {
        
    // }
}
