<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogCategory extends Model
{
    protected $table ='blog_categories';

    protected $fillable = [
        'name',
        'slug',
        'status'
        ];

    protected $hidden =[
    //     'created_at',
    //     'updated_at'
    ];

    // protected $casts = [
    //     'status'=> 'boolean',
    // ]
    
    // public $timestamps = false;

   /*                                                  Begin Relation                                  */ 

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class,'blog_category_id','id');
    }


   /*                                                  End Relation                                  */ 
}
