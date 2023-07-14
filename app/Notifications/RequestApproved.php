<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class RequestApproved extends Notification implements ShouldQueue, ShouldBroadcastNow
{
    use Queueable;
    protected $request_transfer;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
     public function __construct($request_transfer)
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
        return 'request.approved';
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
            'message' => __(':id has been approved by HQ Admin!', ['id' => $this->request_transfer->request_id]),
            'title' => 'Request was approved!',
            'request_id' => $this->request_transfer->request_id,
            'approved_by' => $this->request_transfer->approved_by,
            'url' =>  __('/inventory/operation/request/:id/details', ['id' => $this->request_transfer->request_id])
        ];
    }
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            //
            'id' => $this->id,
            'read_at' => null,
            'message' =>  'Admin has approved your request!',
            'title' => __(':id was approved!', ['id' => $this->request_transfer->request_id]),
            'request_id' => $this->request_transfer->request_id,
            'approved_by' => $this->request_transfer->approved_by,
            'url' =>  __('/inventory/operation/request/:id/details', ['id' => $this->request_transfer->request_id])
        ]);
    }
}
