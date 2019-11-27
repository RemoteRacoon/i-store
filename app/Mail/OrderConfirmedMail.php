<?php

namespace App\Mail;

use App\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     * @param \App\Order
     */

    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('orders.mails.confirmed')
            ->with([
                'label' => $this->order->product->label,
                'rent_rate' => $this->order->product->rent_rate,
                'state' => $this->order->state->state,
                'user' => $this->user->name,
            ]);
    }
}
