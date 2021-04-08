<?php
namespace Entap\Laravel\Carp;

use Entap\Laravel\Carp\Console\Commands\ExpireRelease;
use Entap\Laravel\Carp\Console\Commands\ListPackages;
use Entap\Laravel\Carp\Console\Commands\PublishRelease;
use Illuminate\Support\ServiceProvider;

class CarpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerMigrations();
            $this->registerCommands();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMigrations();
    }

    /**
     * Register the migration files.
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Register the commands
     */
    protected function registerCommands(): void
    {
        $this->commands([
            ExpireRelease::class,
            ListPackages::class,
            PublishRelease::class,
        ]);
    }
}
