<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSocial extends Model
{
    use HasFactory;

    protected $table ='footer_socials';

    protected $fillable =[
        'icon',
        'name',
        'status',
        'url',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];

}
