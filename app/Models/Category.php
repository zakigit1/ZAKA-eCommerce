<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table ='categories';

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


/*                                                  Begin Relation                                  */

    public function subcategories(): HasMany
    {
        
        // return self::hasMany(Subcategory::class);

        // this profissional and detailed : 
        return $this->hasMany(Subcategory::class,'category_id','id');

        // return $this->hasMany(Subcategory::class);
        
    }
    public function childcategories(): HasMany
    {
        

        // this profissional and detailed : 
        return $this->hasMany(Childcategory::class,'category_id','id');

        
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'product_id','id');
    }

/*                                                  End Relation                                  */

}