<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
// class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




    public function getImageAttribute($value)
    {

        /* 
            function asset  he return path of photo  with : 
            localhost/../assets/$value 
            so when we get the path he didnt show the photo  
            --> try the below method 
        */
        /* if you are using public_path function */
         
        // return ($value !== NULL) ? asset( 'storage/Uploads/images/profiles/'.$value) : " ";

        //? Imporatant 
        /*  the issues :
            - in the blog comment when you enter with the admin role account the user image not display 
        */
        //! i need to modify this code  i can delete the role (nrad folder fi ga3 images users myhamech roles)
        // $role = auth()->user()->role ?? 'user';
        // return ($value !== NULL) ? asset( 'storage/Uploads/images/profiles/'.$role.'/'.$value) : " ";
        
        return ($value !== NULL) ? asset( 'storage/Uploads/images/profiles/'.$value) : " ";
  
    }


    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class,'user_id','id');
    }


    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }









}
