<?php

namespace App\Notifications;

use App\Domains\External\Models\ExternalAdmin;
use App\Domains\Stock_Management\Models\RequestTransfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class RequestSubmit extends Notification implements ShouldQueue, ShouldBroadcastNow
{
    use Queueable;
    protected $request_transfer;
    // protected $external_user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
     public function __construct(RequestTransfer $request_transfer)
    {
        # code...
        $this->request_transfer = $request_transfer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }
    public function broadcastType()
    {
        return 'request.submit';
    }
    
    public function broadcastQueue(): string
    {
        return 'default';
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
            'id' => $this->id,
            'read_at' => null,
            'submit_by' => $this->request_transfer->user_id,
            'request_id' => $this->request_transfer->request_id,
            'message' => __(':id has requested for stock movement!', ['id' => $this->request_transfer->user_id]),
            'title' =>  __('New Request :id!',['id' => $this->request_transfer->request_id]),
            'url' =>  __('/inventory/operation/request/:id/details', ['id' => $this->request_transfer->request_id])
        ];
    }
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return (new BroadcastMessage([
            'id' => $this->id,
            'read_at' => null,
            'submit_by' => $this->request_transfer->user_id,
            'request_id' => $this->request_transfer->request_id,
            'message' => __(':id has requested for stock movement!', ['id' => $this->request_transfer->user_id]),
            'title' => __('New Request :id!',['id' => $this->request_transfer->request_id]),
            'url' =>  __('/inventory/operation/request/:id/details', ['id' => $this->request_transfer->request_id])
        ]))->onQueue('broadcasts');
    }
}
