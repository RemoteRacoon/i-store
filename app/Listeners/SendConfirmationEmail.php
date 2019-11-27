<?php

namespace App\Listeners;

use App\Events\OrderConfirmedEvent;
use App\Mail\OrderConfirmedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendConfirmationEmail implements ShouldQueue
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
     * @param  OrderConfirmedEvent  $event
     * @return void
     */
    public function handle(OrderConfirmedEvent $event)
    {
        Mail::to($event->user->email)->send(new OrderConfirmedMail($event->order, $event->user));
    }
}
