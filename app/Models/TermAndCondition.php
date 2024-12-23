<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TermAndCondition extends Model
{
    
    protected $table ='term_and_conditions';
    protected $fillable = [
        'content',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];

    
    // public $timestamps = false;

}
