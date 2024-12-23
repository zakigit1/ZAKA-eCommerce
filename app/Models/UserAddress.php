<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    protected $table ='user_addresses';

    protected $guarded =[
        'id',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];

    // protected $casts = [
    //     
    // ]
    
    // public $timestamps = false;





    public function user(): BelongsTo
    {
        // return $this->belongsTo(User::class);
        return $this->belongsTo(User::class,'user_id','id','id');
    }
}
