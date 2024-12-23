<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LogoSetting extends Model
{
    

    public $table = 'logo_settings';

    protected $fillable = [
        'logo',
        'favicon',
    ];

    protected $hidden =[
        'created_at',
        'updated_at'
    ];

    // protected $casts = [
    //     'status'=> 'boolean',
    // ]
    
    // public $timestamps = false;

    // /*                                                 Begin GET                                          */
    public function getLogoAttribute($value)
    {
        return ($value !== NULL) ? asset( 'storage/Uploads/images/logoAndfavicon/'.$value) : null;
    }
    public function getFaviconAttribute($value)
    {
        return ($value !== NULL) ? asset( 'storage/Uploads/images/logoAndfavicon/'.$value) : null;
    }
/*                                                 End GET                                            */
}
