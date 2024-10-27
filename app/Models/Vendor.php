<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory;

    protected $table ='vendors';

    protected $guarded =[
        'id',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];

    // protected $casts = [
    //     'status'=> 'boolean',
    // ]
    
    // public $timestamps = false;
##################################################################################################################



/*                                                 Begin Local Scopes                                 */
   
     
/*                                                  End Local Scopes                                  */
    /*                                                 Begin GET                                          */
    public function getBannerAttribute($value)
    {
        return ($value !== NULL) ? asset( 'storage/Uploads/images/vendors/'.$value) : " ";
    }
    /*                                                 End GET                                            */


/*                                                  Begin Relation                                  */

    public function user():BelongsTo
    {
        // return $this->belongsTo(User::class);
        return $this->belongsTo(User::class,'user_id','id','id');
    }
    
    public function products():HasMany
    {
        return $this->hasMany(Product::class,'vendor_id','id');
    }



/*                                                  End Relation                                  */
}