<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterInfo extends Model
{
    use HasFactory;

    protected $table ='footer_infos';

    protected $fillable =[
        'logo',
        'phone',
        'email',
        'address',
        'copyright',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];


    
    // public $timestamps = false;
    
##################################################################################################################

/*                                                 Begin GET                                          */
public function getLogoAttribute($value)
{
    return ($value !== NULL) ? asset( 'storage/Uploads/images/footer/'.$value) : " ";
}
/*                                                 End GET                                            */

}
