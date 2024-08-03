<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
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
    
     
/*                                                  End Local Scopes                                  */

    /*                                                 Begin GET                                          */

    /*                                                 End GET                                            */


/*                                                  Begin Relation                                  */

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

   public function items(){
       return $this->hasMany(ProductVariantItem::class,'product_variant_id','id');
   }


/*                                                  End Relation                                  */
}
