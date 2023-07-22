<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use TheBachtiarz\EAV\Interfaces\Configs\EavConfigInterface;
use TheBachtiarz\EAV\Providers\AppsProvider;

use function app;
use function assert;
use function config_path;
use function database_path;

class ServiceProvider extends LaravelServiceProvider
{
    public function register(): void
    {
        $appsProvider = app()->make(AppsProvider::class);
        assert($appsProvider instanceof AppsProvider);

        $appsProvider->registerConfig();

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands(AppsProvider::COMMANDS);
    }

    public function boot(): void
    {
        if (! app()->runningInConsole()) {
            return;
        }

        $_configName  = EavConfigInterface::CONFIG_NAME;
        $_publishName = 'thebachtiarz-eav';

        $this->publishes([__DIR__ . "/../config/$_configName.php" => config_path("$_configName.php")], "$_publishName-config");
        $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], "$_publishName-migrations");
    }
}
