<?php

namespace App\Notifications;

use App\Domains\Stock_Management\Models\ProductBox;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlmostExpiredProducts extends Notification
{
    use Queueable;
    protected $items;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProductBox $items)
    {
        //
        $this->items =$items;
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

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
            'title' => 'Expired products in warehouse!',
            'message' => 'You have expired products. Check them out!',
            'read_at' => null,
            'box_code' => $this->items->box_code,
            'exp_date' => $this->items->exp_date,
            'product' => $this->items->product_code
        ];
    }
}
