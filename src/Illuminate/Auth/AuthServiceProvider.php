<?php

namespace MatthiasWilbrink\AfterGate\Illuminate\Auth;

use MatthiasWilbrink\AfterGate\Illuminate\Auth\Access\Gate;
use Illuminate\Auth\AuthServiceProvider as IlluminateServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class AuthServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        $this->registerAccessGate();
    }

    /**
     * Register the access gate service.
     *
     * @return void
     */
    protected function registerAccessGate()
    {
        $this->app->singleton(GateContract::class, function ($app) {
            return new Gate($app, function () use ($app) {
                return call_user_func($app['auth']->userResolver());
            });
        });
    }
}
