<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class EmailConfiguration extends Model
{

    protected $table ='email_configurations';

    protected $fillable = [
        'name',
        'email',
        'host',
        'username',
        'password',
        'port',
        'encryption',

    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    // public $timestamps = false;
}
