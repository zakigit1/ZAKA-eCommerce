<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    
    protected $table ='coupon_users';



    protected $fillable = [
        'coupon_id',
        'user_id',
        'available_use',
    ];

    protected $hidden =[
        'created_at',
        'updated_at',
        // 'pivot'
    ];

    protected $casts = [
        'coupon_id' => 'integer',
        'user_id' => 'integer',
        'max_use' => 'integer',

        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

       // public $timestamps = false;



    public function coupon(){
        return $this->belongsTo(Coupon::class,'coupon_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    
}
