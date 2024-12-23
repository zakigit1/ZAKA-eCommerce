<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VendorCondition extends Model
{
    protected $table = "vendor_conditions";
    protected $fillable = [
        'content',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];


    // public $timestamps = false;
}
