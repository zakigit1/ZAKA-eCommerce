<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $message;
    public $receiver_id;
    public $data_time;


    /**
     * Create a new event instance.
     */
    public function __construct($message , $receiver_id, $data_time)
    {
        $this->message = $message;
        $this->receiver_id = $receiver_id;
        $this->receiver_id = $receiver_id;
        $this->data_time = $data_time;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('message.'.$this->receiver_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'receiver_id' => $this->receiver_id,
            'data_time' => $this->data_time,
            'sender_id' => Auth::user()->id,
            'sender_image' => Auth::user()->image,
        ];
    }
}
