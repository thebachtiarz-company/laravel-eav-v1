<?php

namespace TheBachtiarz\EAV\Providers;

use TheBachtiarz\Base\BaseConfigInterface;
use TheBachtiarz\EAV\Interfaces\Config\EavConfigInterface;

class DataProvider
{
    //

    /**
     * List of config who need to registered into current project.
     * Perform by eav app module.
     *
     * @return array
     */
    public function registerConfig(): array
    {
        $registerConfig = [];

        // ! eav
        $configRegistered = tbbaseconfig(BaseConfigInterface::CONFIG_REGISTERED);
        $registerConfig[] = [
            BaseConfigInterface::CONFIG_NAME . '.' . BaseConfigInterface::CONFIG_REGISTERED => array_merge(
                $configRegistered,
                [
                    EavConfigInterface::CONFIG_NAME
                ]
            )
        ];

        return $registerConfig;
    }
}
