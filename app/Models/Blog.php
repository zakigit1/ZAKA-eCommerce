<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    protected $table ='blogs';

    protected $guarded =[
        'id',
    ];

    protected $hidden =[
    //     'created_at',
    //     'updated_at'
    ];

    // protected $casts = [
    //     'status'=> 'boolean',
    // ]
    
    // public $timestamps = false;
    ##################################################################################################################

    /*                                                 Begin GET                                          */
        public function getImageAttribute($value)
        {
            return ($value !== NULL) ? asset( 'storage/Uploads/images/blogs/'.$value) : " ";
        }
    /*                                                 End GET                                            */


    /*                                                  Begin Relation                                  */ 

    
        public function user(): BelongsTo
        {
            // return $this->belongsTo(User::class);
            return $this->belongsTo(User::class,'user_id','id','id');
        }

        public function blogcategory(): BelongsTo
        {
            return $this->belongsTo(BlogCategory::class,'blog_category_id','id');
        }

        public function comments(): HasMany
        {
            return $this->hasMany(BlogComment::class,'blog_id','id');
        }


    /*                                                  End Relation                                  */ 



    
}
