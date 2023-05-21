<?php

use TheBachtiarz\EAV\Interfaces\Config\EavConfigInterface;

if (!function_exists('tbeavconfig')) {
    /**
     * TheBachtiarz eav config
     *
     * @param string|null $keyName Config key name | null will return all
     * @param boolean|null $useOrigin Use original value from config
     * @return mixed
     */
    function tbeavconfig(?string $keyName = null, ?bool $useOrigin = true): mixed
    {
        $configName = EavConfigInterface::CONFIG_NAME;

        return tbconfig($configName, $keyName, $useOrigin);
    }
}
