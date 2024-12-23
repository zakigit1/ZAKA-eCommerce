<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReviewGallery extends Model
{
    
    protected $table = 'product_review_galleries';

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

    public function review(): BelongsTo
    {

        return $this->belongsTo(ProductReview::class,'product_review_id');
    }




}
