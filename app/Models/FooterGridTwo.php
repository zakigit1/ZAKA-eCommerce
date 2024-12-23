<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class FooterGridTwo extends Model
{
    


    protected $table ='footer_grid_twos';

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
