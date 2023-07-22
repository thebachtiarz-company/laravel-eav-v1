<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Interfaces\Models\Data;

interface EntityAttributeValueCollectionInterface
{
    /**
     * Get data
     */
    public function getData(string|null $attribute = null): mixed;

    /**
     * Set data
     */
    public function setData(string $attribute, mixed $value): self;
}
