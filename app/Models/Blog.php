<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table ='blogs';

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

    /*                                                 Begin GET                                          */
        public function getImageAttribute($value)
        {
            return ($value !== NULL) ? asset( 'storage/Uploads/images/blogs/'.$value) : " ";
        }
    /*                                                 End GET                                            */








    /*                                                  Begin Relation                                  */ 

    
        public function user(){
            // return $this->belongsTo(User::class);
            return $this->belongsTo(User::class,'user_id','id','id');
        }

        public function blogcategory(){
            return $this->belongsTo(BlogCategory::class,'blog_category_id','id');
        }

        public function comments(){
            return $this->hasMany(BlogComment::class,'blog_id','id');
        }


    /*                                                  End Relation                                  */ 



    
}
