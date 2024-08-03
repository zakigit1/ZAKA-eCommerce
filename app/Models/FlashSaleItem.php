<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{
    use HasFactory;


    protected $table ='flash_sale_items';

    protected $fillable =[
        'product_id',
        'flash_sale_id',
        'show_at_home',
        'status',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];


/*                                                 Begin Local Scopes                                 */
public function scopeActive($query) // to show just the active slide in store 
{
    return $query->where('status', 1);
}       
/*                                                  End Local Scopes                                  */



/*                                                  Begin Relation                                  */
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id','id');
    }
    public function flashSale(){
        return $this->belongsTo(FlashSale::class,'flash_sale_id','id','id');
    }
/*                                                  End Relation                                  */

}
