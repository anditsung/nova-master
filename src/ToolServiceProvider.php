<?php

namespace Tsung\NovaMaster;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Tsung\NovaMaster\Commands\Install;
use Tsung\NovaMaster\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ( $this->app->runningInConsole() ) {
            $this->registerPublishing();
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-master');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::tools($this->registerTools());

        });
    }

    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config' => config_path('/'),
        ], 'novamaster-config');
    }

    protected function registerTools()
    {
        return [
            new NovaMaster()
        ];
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/nova-master')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Install::class,
        ]);
    }
}
