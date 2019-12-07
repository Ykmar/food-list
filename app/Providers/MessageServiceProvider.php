<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Message\MessageService;

class MessageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MessageService::class, function ($app) {
            return new MessageService($app['session.store']);
        });
    }
}
