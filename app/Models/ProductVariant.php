<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    
    protected $table ='product_variants';

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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

   public function items(): HasMany
   {
       return $this->hasMany(ProductVariantItem::class,'product_variant_id','id');
   }


/*                                                  End Relation                                  */
}
