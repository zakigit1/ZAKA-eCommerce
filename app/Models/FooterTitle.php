<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterTitle extends Model
{


    protected $table ='footer_titles';

    protected $fillable =[
        'footer_grid_two_title',
        'footer_grid_three_title',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];





}
