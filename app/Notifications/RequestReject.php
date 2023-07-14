<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestReject extends Notification implements ShouldQueue, ShouldBroadcastNow
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
        return 'request.reject';
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
            'message' => __(':id has been rejected by HQ Admin!', ['id' => $this->request_transfer->request_id]),
            'title' => 'Request was Rejected!',
            'request_id' => $this->request_transfer->request_id,
            'rejected_by' => $this->request_transfer->rejected_by,
            // 'submit_to' => $th
        ];
    }
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            //
            'id' => $this->id,
            'read_at' => null,
            'message' => __(':id has been rejected by HQ Admin!', ['id' => $this->request_transfer->request_id]),
            'title' => 'Request was Rejected!',
            'request_id' => $this->request_transfer->request_id,
            'rejected_by' => $this->request_transfer->rejected_by,
            // 'submit_to' => $th
        ]);
    }
}
