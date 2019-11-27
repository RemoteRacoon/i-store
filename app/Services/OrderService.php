<?php


namespace App\Services;


use App\Events\OrderConfirmedEvent;
use App\Order;
use App\State;
use App\User;

class OrderService
{
    public function confirm(Order $confirmed, User $user)
    {
        event(new OrderConfirmedEvent($confirmed, $user));
        return response()->json($confirmed, 200);
    }
}