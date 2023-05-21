<?php

namespace TheBachtiarz\EAV;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use TheBachtiarz\EAV\Interfaces\Config\EavConfigInterface;
use TheBachtiarz\EAV\Providers\AppsProvider;

class ServiceProvider extends LaravelServiceProvider
{
    //

    public function register(): void
    {
        /** @var AppsProvider $appsProvider */
        $appsProvider = app()->make(AppsProvider::class);

        $appsProvider->registerConfig();

        if ($this->app->runningInConsole()) {
            $this->commands(AppsProvider::COMMANDS);
        }
    }

    public function boot(): void
    {
        if (app()->runningInConsole()) {
            $_configName = EavConfigInterface::CONFIG_NAME;
            $_publishName = 'thebachtiarz-eav';

            // $this->publishes([__DIR__ . "/../config/$_configName.php" => config_path("$_configName.php")], "$_publishName-config");
            // $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], "$_publishName-migrations");
        }
    }
}
