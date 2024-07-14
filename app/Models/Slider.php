<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $table ='sliders';

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

    /*                                                 Begin GET                                          */
    public function getBannerAttribute($value)
    {
        return ($value !== NULL) ? asset( 'storage/Uploads/images/sliders/'.$value) : " ";
    }
    /*                                                 End GET                                            */
}
