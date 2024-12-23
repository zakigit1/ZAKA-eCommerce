<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CODSetting extends Model
{
    protected $table ='c_o_d_settings';
    protected $fillable =[ 
        'status',
    ];
    protected $hidden =[
        'created_at',
        'updated_at'
    ];

    // protected $casts = [
    //     'status'=> 'boolean',
    // ]
    
    // public $timestamps = false;
}
