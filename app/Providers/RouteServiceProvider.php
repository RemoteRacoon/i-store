<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**ts
     * This namespace is applied to your controller routes.
     *:
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    private $api_namespace = 'App\Http\Controllers\Api';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::bind('user', function ($user_id) {
            return \App\User::where('id', $user_id)->first() ?? abort(404);
        });
        Route::bind('order', function ($order_id) {
            return \App\Order::where('id', $order_id)->first() ?? abort(404);
        });

        Route::bind('product', function ($product_id) {
            return \App\Product::where('id', $product_id)->first() ?? abort(404);
        });
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapOrderRoutes();

        $this->mapProductRoutes();

        $this->mapAdminRoutes();

        $this->mapAuthRoutes();

    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->api_namespace)
            ->group(base_path('routes/api.php'));
    }

    private function mapOrderRoutes()
    {
        Route::prefix('api/orders')
            ->middleware(['auth:api'])
            ->namespace($this->api_namespace)
            ->group(base_path('routes/orders.php'));
    }


    private function mapProductRoutes()
    {
        Route::prefix('api/products')
            ->namespace($this->api_namespace)
            ->group(base_path('routes/products.php'));
    }

    private function mapAdminRoutes()
    {
        Route::prefix('api/admin/users')
            ->middleware(['api', 'auth:api', 'admin'])
            ->namespace($this->api_namespace)
            ->group(base_path('routes/admin.php'));
    }


    private function mapAuthRoutes()
    {
        Route::prefix('api')
            ->namespace($this->api_namespace)
            ->group(base_path('routes/auth.php'));
    }

}
