<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $table ='newsletter_subscribers';
    protected $fillable = [
        'email',
        'verified_token',
        'is_verified',
    ];

    protected $hidden =[
    //     'created_at',
    //     'updated_at'
    ];

    // protected $casts = [
    //     'status'=> 'boolean',
    // ]
    
    // public $timestamps = false;
}
