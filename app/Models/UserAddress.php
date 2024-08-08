<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
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





    public function user(){
        // return $this->belongsTo(User::class);
        return $this->belongsTo(User::class,'user_id','id','id');
    }
}
