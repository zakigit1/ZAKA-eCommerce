<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReviewGallery extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];




    public function getImageAttribute($value)
    {
        return ($value !== NULL) ? asset( 'storage/Uploads/images/products/review/'.$value) : " ";
    }





}
