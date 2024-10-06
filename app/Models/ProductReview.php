<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'vendor_id',
        'user_id',
        'rating',
        'review',
        'status'
    ];

        
    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }


    public function productReviewGalleries(){
        return $this->hasMany(ProductReviewGallery::class,'product_review_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
