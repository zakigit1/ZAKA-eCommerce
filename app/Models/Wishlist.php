<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    
    protected $table ='wishlists';

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


    /*                                                  Begin Relation                                  */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    

    /*                                                  End Relation                                  */


}
