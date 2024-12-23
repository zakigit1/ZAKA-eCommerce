<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    protected $table ='chats';
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'seen',
    ];


    protected $hidden =[
    //     'created_at',
    //     'updated_at'
    ];

    
    // public $timestamps = false;


    /**
     *  this relation to get receiver informations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiverProfile():BelongsTo
    {
        return $this->belongsTo(User::class,'receiver_id','id')
                ->select(['id','image','name']);
    }

    /**
     *  this relation to get sender informations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function senderProfile():BelongsTo
    {
        return $this->belongsTo(User::class,'sender_id','id')
                ->select(['id','image','name']);
    }

}
