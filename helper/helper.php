<?php

declare(strict_types=1);

use TheBachtiarz\EAV\Interfaces\Configs\EavConfigInterface;

if (! function_exists('tbeavconfig')) {
    /**
     * TheBachtiarz eav config
     *
     * @param string|null $keyName   Config key name | null will return all
     * @param bool|null   $useOrigin Use original value from config
     */
    function tbeavconfig(string|null $keyName = null, bool|null $useOrigin = true): mixed
    {
        $configName = EavConfigInterface::CONFIG_NAME;

        return tbconfig($configName, $keyName, $useOrigin);
    }
}
