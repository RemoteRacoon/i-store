<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('OrderService', 'App\Services\OrderService');
    }


    public function boot()
    {
        //
    }
}
