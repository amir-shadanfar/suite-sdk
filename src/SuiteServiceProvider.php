<?php

namespace Teknasyon\Suite;

use Illuminate\Support\ServiceProvider;


class SuiteServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/suite.php', 'suite');

        // Register the service the package provides.
        $this->app->singleton('suite', function ($app) {
            return new Suite;
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['suite'];
    }
}