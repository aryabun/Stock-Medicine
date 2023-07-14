<?php

namespace App\Events;

use Auth;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewRequestNotification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $admin;

    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($admin, $username)
    {
        //
        $this->admin = $admin;
        $this->username = $username;
        $this->message  = "{$username} has requested for stock movement!";
        
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('request.submit.'.$this->admin);
    }
    public function broadcastAs()
    {
        return 'new-request';
    }
}
