<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PusherConfiguration extends Model
{
    use HasFactory;
    protected $fillable = [
        'pusher_app_id',
        'pusher_key',
        'pusher_secret',
        'pusher_cluster',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
