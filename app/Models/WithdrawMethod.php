<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WithdrawMethod extends Model
{
    protected $table ='withdraw_methods';
    protected $guarded =[
        'id',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];





    public function withdrawRequests(): HasMany
    {
        return $this->hasMany(WithdrawRequest::class,'withdraw_method_id','id');
    }
}
