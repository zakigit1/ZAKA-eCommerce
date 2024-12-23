<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class HomePageSetting extends Model
{
    
    protected $table ='home_page_settings';
    protected $fillable = [
        'key',
        'value'
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
