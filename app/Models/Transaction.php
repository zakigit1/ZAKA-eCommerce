<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    
    protected $table = "transactions";

    protected $fillable = [
        'order_id',
        'transaction_id',
        'payment_method',
        'amount',
        'amount_real_currency',
        'amount_real_currency_name',
    ];
    protected $hidden = [
        // 'created_at',
        // 'updated_at'
    ];


    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id');
    }

}
