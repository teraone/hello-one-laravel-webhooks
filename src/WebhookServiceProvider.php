<?php

namespace HelloOne\Laravel\Webhooks;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class WebhookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('hello-one-webhooks.php'),
        ]);
        $this->mergeConfigFrom( __DIR__.'/../config/config.php' , 'hello-one-webhooks');

        $this->app->make(WebhookController::class, [WebhookRequest::class] );

        $this->registerRoutes();


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('hello-one-webhooks.php'),
            ], 'hello-one-webhooks');

        }
    }

    protected function registerRoutes()
    {
        if (config('hello-one-webhooks.routes.publish', true)) {
            Route::group($this->routeConfiguration(), function () {
                $this->loadRoutesFrom(__DIR__.'../../routes/web.php');
            });
        }

    }

    protected function routeConfiguration()
    {
        return [
            'middleware' => config('hello-one-webhooks.routes.middleware'),
            'prefix' => config('hello-one-webhooks.routes.prefix'),
        ];
    }

}
