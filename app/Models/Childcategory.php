<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Childcategory extends Model
{

    protected $table ='childcategories';

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

    public function category(): BelongsTo
    {

        //? this is more profissional : 
            
        // return $this->belongsTo(Category::class,
        // 'category_id','id','id');
    
        
        /** 
         * ? you can use this also if the foreign key are convinsion (like our parent model is category the name of foreign key
         * ?  is category_id in this case you can dont write the foreign key)
        */

        return $this->belongsTo(Category::class);
        
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


/*                                                  End Relation                                  */

}

