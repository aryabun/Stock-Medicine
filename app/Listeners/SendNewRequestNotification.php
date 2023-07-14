<?php

namespace App\Listeners;

use App\Events\NewRequestNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewRequestNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewRequestNotification  $event
     * @return void
     */
    public function handle(NewRequestNotification $event)
    {
        //
    }
}
