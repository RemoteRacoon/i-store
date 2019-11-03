<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait OrderProcessable
{
    private function processOrder(Collection $orders)
    {
        $orders = $orders->toArray();
        $processed = null;
        foreach ($orders as $order) {
            $order = array_filter($order, function ($k) {
                return $k === 'id' ||
                    $k === 'user_id' ||
                    $k === 'state' ||
                    $k === 'product' ||
                    $k === 'rent_date_start' ||
                    $k === 'rent_date_expire';
            }, ARRAY_FILTER_USE_KEY);
            $processed = $orders;
        }
        return $processed;
    }
}
