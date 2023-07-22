<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Models;

use TheBachtiarz\Base\App\Interfaces\Models\AbstractModelInterface;
use TheBachtiarz\Base\App\Models\AbstractModel;
use TheBachtiarz\EAV\Interfaces\Models\EavEntityInterface;
use TheBachtiarz\EAV\Traits\Models\EavEntityScopeTrait;
use Throwable;

use function serialize;
use function unserialize;

class EavEntity extends AbstractModel implements EavEntityInterface
{
    use EavEntityScopeTrait;

    /**
     * Constructor
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(self::TABLE_NAME);
        $this->fillable(self::ATTRIBUTE_FILLABLE);

        parent::__construct($attributes);
    }

    // ? Getter Modules

    /**
     * Get model entity
     */
    public function getModelEntity(): AbstractModelInterface
    {
        return $this->__get(self::MODEL_ENTITY);
    }

    /**
     * Get entity name
     */
    public function getEntityName(): string|null
    {
        return $this->__get(self::ATTRIBUTE_ENTITY);
    }

    /**
     * Get entity id
     */
    public function getEntityId(): int|null
    {
        return $this->__get(self::ATTRIBUTE_ENTITYID);
    }

    /**
     * Get attribute name
     */
    public function getAttrName(): string|null
    {
        return $this->__get(self::ATTRIBUTE_NAME);
    }

    /**
     * Get attribute value
     */
    public function getAttrValue(): mixed
    {
        try {
            return unserialize($this->__get(self::ATTRIBUTE_VALUE));
        } catch (Throwable) {
            return null;
        }
    }

    // ? Setter Modules

    /**
     * Set model entity
     */
    public function setModelEntity(AbstractModelInterface $abstractModelInterface): self
    {
        $this->__set(self::MODEL_ENTITY, $abstractModelInterface);
        $this->setEntityName($abstractModelInterface::class);
        $this->setEntityId($abstractModelInterface->getId());

        return $this;
    }

    /**
     * Set entity name
     */
    public function setEntityName(string $entityName): self
    {
        $this->__set(self::ATTRIBUTE_ENTITY, $entityName);

        return $this;
    }

    /**
     * Set entity id
     */
    public function setEntityId(int $entityId): self
    {
        $this->__set(self::ATTRIBUTE_ENTITYID, $entityId);

        return $this;
    }

    /**
     * Set attribute name
     */
    public function setAttrName(string $attrName): self
    {
        $this->__set(self::ATTRIBUTE_NAME, $attrName);

        return $this;
    }

    /**
     * Set attribute value
     */
    public function setAttrValue(mixed $attrValue): self
    {
        $this->__set(self::ATTRIBUTE_VALUE, serialize($attrValue));

        return $this;
    }
}
