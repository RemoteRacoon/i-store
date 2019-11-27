<?php

namespace App\Events;

use App\Order;
use App\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $order;

    public function __construct(Order $order, User $user)
    {
        $this->user = $user;
        $this->order = $order;
    }

}
