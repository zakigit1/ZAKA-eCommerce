<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterGridThree extends Model
{



    protected $table ='footer_grid_threes';

    protected $fillable =[
        'name',
        'status',
        'url',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];
}
