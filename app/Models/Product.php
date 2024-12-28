<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    

    protected $table ='products';

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
    public function getThumbImageAttribute($value)
    {
        return ($value !== NULL) ? asset( 'storage/Uploads/images/products/thumb-images/'.$value) : " ";
    }
    /*                                                 End GET                                            */


/*                                                  Begin Relation                                  */

    public function category(): BelongsTo
    {

        //? this is more profissional :

        // return $this->belongsTo(Category::class,
        // 'category_id','id','id');


        /**
         * ? you can use this also if the foreign key are convinsion (like our parent model is category the name of foreign key
         * ?  is category_id in this case you can dont write the foreign key)
        */

        return $this->belongsTo(Category::class,'category_id','id','id');

    }

    public function subcategory(): BelongsTo
    {

        //? this is more profissional :

        return $this->belongsTo(Subcategory::class,
        'sub_category_id','id','id');


        /**
         * ? you can use this also if the foreign key are convinsion (like our parent model is category the name of foreign key
         * ?  is category_id in this case you can dont write the foreign key)
        */

        // return $this->belongsTo(Subcategory::class);
    }

    public function childcategory(): BelongsTo
    {

        //? this is more profissional :

        return $this->belongsTo(Childcategory::class,
        'child_category_id','id','id');


        /**
         * ? you can use this also if the foreign key are convinsion (like our parent model is category the name of foreign key
         * ?  is category_id in this case you can dont write the foreign key)
        */

        // return $this->belongsTo(Subcategory::class);

    }

    public function gallery(): HasMany
    {
        return $this->hasMany(ProductImageGallery::class,'product_id','id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class,'product_id','id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class,'vendor_id','id','id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class,'brand_id','id','id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class,'product_id','id');
    }

    public function flashSaleItems(): HasMany
    {
        return $this->hasMany(FlashSaleItem::class,'product_id','id');
    }

/*                                                  End Relation                                  */
}
