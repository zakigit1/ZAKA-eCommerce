<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WithdrawRequest extends Model
{
    
    protected $table ='withdraw_requests';

    protected $guarded =[
        'id',
    ];

    protected $hidden =[
        // 'created_at',
        // 'updated_at'
    ];


    public function method(): BelongsTo
    {
        return $this->belongsTo(WithdrawMethod::class,'withdraw_method_id','id','id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class,'vendor_id','id','id');
    }
}
