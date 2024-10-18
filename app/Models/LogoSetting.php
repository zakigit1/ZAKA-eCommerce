<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoSetting extends Model
{
    use HasFactory;

    public $table = 'logo_settings';

    protected $fillable = [
        'logo',
        'favicon',
    ];

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
