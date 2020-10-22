<?php

// 'src/CrudViewGeneratorServiceProvider.php'

namespace Codegaf\CrudViewGenerator;

use Illuminate\Support\ServiceProvider;

class CrudViewGeneratorServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'crudgenerator');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'crudgenerator');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            /*
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('crudgenerator.php'),
            ], 'config');
            */

            $this->publishes([
                __DIR__.'/stubs/custom' => base_path('/stubs/custom'),
            ], 'stubs');

            $this->publishes([
                __DIR__.'/stubs/CrudViewGenerator.stub' => app_path('Console/Commands/CrudViewGenerator.php'),
            ], 'commands');

            $this->commands([
                CrudViewGenerator::class,
            ]);

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/crudgenerator'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/crudgenerator'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/crudgenerator'),
            ], 'lang');*/
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        //$this->mergeConfigFrom(__DIR__.'/../config/config.php', 'crudgenerator');

        // Register the main class to use with the facade
        $this->app->singleton('crudviewgenerator', function () {
            return new CrudViewGenerator;
        });
    }

}