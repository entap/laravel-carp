<?php
namespace Entap\Laravel\Carp;

use Illuminate\Support\Facades\Route;

class Carp
{
    /**
     * Binds the routes into the controller.
     */
    public static function routes()
    {
        Route::group(config('carp.route'), function ($router) {
            (new RouteRegistrar($router))->all();
        });
    }
}
