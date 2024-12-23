<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{

    protected $table ='brands';

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
    public function scopeIsFeatured($query) // to show just the active slide in store 
    {
        return $query->where('is_featured', 1);
    }       
/*                                                  End Local Scopes                                  */

/*                                                 Begin GET                                          */
    public function getLogoAttribute($value)
    {
        return ($value !== NULL) ? asset( 'storage/Uploads/images/brands/'.$value) : " ";
    }
/*                                                 End GET                                            */


/*                                                  Begin Relation                                  */


    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'brand_id','id');
    }



/*                                                  End Relation                                  */

}
