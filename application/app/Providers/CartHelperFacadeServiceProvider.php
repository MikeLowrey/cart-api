<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CartHelperFacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        \App::bind('cartHelper', function () {
            return new \App\Helpers\CartHelper();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
