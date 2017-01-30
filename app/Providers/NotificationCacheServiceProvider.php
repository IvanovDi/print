<?php

namespace App\Providers;

use App\Components\Messages;
use App\Components\NotificationCacheComponent;
use Illuminate\Support\ServiceProvider;

class NotificationCacheServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('NotificationCache', function () {
            return new NotificationCacheComponent();
        });
    }
}
