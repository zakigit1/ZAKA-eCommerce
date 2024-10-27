<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    use HasFactory;


    protected $guarded =[
        'id',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];


    public function method(){
        return $this->belongsTo(WithdrawMethod::class,'withdraw_method_id','id','id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class,'vendor_id','id','id');
    }
}
