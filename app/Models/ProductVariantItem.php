<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariantItem extends Model
{
    
    protected $table ='product_variant_items';

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
        public function scopeActive($query) // to show just the active slide in store 
        {
            return $query->where('status', 1);
        }
    
     
/*                                                  End Local Scopes                                  */

    /*                                                 Begin GET                                          */

    /*                                                 End GET                                            */


/*                                                  Begin Relation                                  */

    // public function product(){
    //     return $this->belongsTo(Product::class,'product_id','id');
    // }
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class,'product_variant_id','id');
    }

   


/*                                                  End Relation                                  */
}

