<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class RazorpaySetting extends Model
{
    

    protected $table = 'razorpay_settings';

    protected $fillable = [
        'status',
        'country_name',
        'currency_name',
        'currency_rate',
        'razorpay_key',
        'razorpay_secret_key',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
