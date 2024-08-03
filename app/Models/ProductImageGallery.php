<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImageGallery extends Model
{
    use HasFactory;

    protected $table ='product_image_galleries';

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
    public function getImageAttribute($value)
    {
        return ($value !== NULL) ? asset( 'storage/Uploads/images/products/gallery/'.$value) : " ";
    }
    /*                                                 End GET                                            */


/*                                                  Begin Relation                                  */

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

   


/*                                                  End Relation                                  */
}

