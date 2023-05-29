<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Models\Data;

use TheBachtiarz\EAV\Interfaces\Model\Data\EntityAttributeValueCollectionInterface;

class EntityAttributeValueCollection implements EntityAttributeValueCollectionInterface
{
    /**
     * Entity Attribute Value Collection
     *
     * @var array
     */
    protected array $_collection = [];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->_collection = $data;
    }

    /**
     * Get data
     */
    public function getData(string|null $attribute = null): mixed
    {
        return $attribute ? @$this->_collection[$attribute] ?? $this->_collection : $this->_collection;
    }

    /**
     * Set data
     */
    public function setData(string $attribute, mixed $value): self
    {
        $this->_collection[$attribute] = $value;

        return $this;
    }
}
