<?php

namespace TheBachtiarz\EAV\Providers;

class AppsProvider
{
    //

    public const COMMANDS = [];

    /**
     * Register config
     *
     * @return void
     */
    public function registerConfig(): void
    {
        /** @var DataProvider $_dataProvider */
        $_dataProvider = app()->make(DataProvider::class);

        foreach ($_dataProvider->registerConfig() as $key => $register)
            config($register);
    }
}
