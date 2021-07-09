<?php

namespace Suite\Suite;

use Illuminate\Support\ServiceProvider;

/**
 * Class SuiteServiceProvider
 * @package Suite\Suite
 */
class SuiteServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/suite.php', 'suite');

        // Register the service the package provides.
        $this->app->singleton('suite', function ($app, Auth $auth) {
            return new Suite($auth);
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
