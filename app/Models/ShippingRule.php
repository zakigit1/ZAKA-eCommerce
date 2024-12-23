<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

class ShippingRule extends Model
{
    protected $table ='shipping_rules';
    protected $fillable = [
        'name',
        'type',
        'min_cost',
        'cost',
        'status',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];


    
    // public $timestamps = false;


}
