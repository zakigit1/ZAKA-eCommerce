<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductReview extends Model
{
    protected $table ='product_reviews';

    protected $fillable = [
        'product_id',
        'vendor_id',
        'user_id',
        'rating',
        'review',
        'status'
    ];

        
    protected $hidden = [
        // 'created_at',
        // 'updated_at',
    ];


    public function user(): BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }


    public function productReviewGalleries(): HasMany
    {
        return $this->hasMany(ProductReviewGallery::class,'product_review_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
