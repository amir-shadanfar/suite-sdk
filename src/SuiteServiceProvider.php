<?php

namespace Teknasyon\Suite;

use Illuminate\Support\ServiceProvider;

class SuiteServiceProvider extends ServiceProvider
{
    // Http events &listeners
    protected $listen = [
        'Illuminate\Http\Client\Events\RequestSending' => [
            'Teknasyon\Suite\Listeners\LogRequestSending',
        ],
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'teknasyon');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'teknasyon');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
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

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/suite.php' => config_path('suite.php'),
        ], 'suite.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/teknasyon'),
        ], 'suite.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/teknasyon'),
        ], 'suite.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/teknasyon'),
        ], 'suite.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
