<?php

namespace App\Events;

use App\Domains\Stock_Management\Models\RequestTransfer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequestApprovedNotification  implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request_transfer;
    /**
     * Create a new event instance.
     *
     * @var \App\Domains\Stock_Management\Models\RequestTransfer
     * @return void
     */
    public function __construct(RequestTransfer $request_transfer)
    {
        //
        $this->request_transfer = $request_transfer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('request.approved.'.$this->request_transfer->user_id);
    }
    public function broadcastAs()
    {
        return 'request_confirm';
    }
}
