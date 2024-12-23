<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{


    protected $table ='flash_sales';

    protected $fillable =[
        'end_date',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];
}
