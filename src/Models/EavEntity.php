<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Models;

use TheBachtiarz\Base\App\Interfaces\Model\AbstractModelInterface;
use TheBachtiarz\Base\App\Models\AbstractModel;
use TheBachtiarz\EAV\Interfaces\Model\EavEntityInterface;
use TheBachtiarz\EAV\Traits\Model\EavEntityScopeTrait;
use Throwable;

use function serialize;
use function unserialize;

class EavEntity extends AbstractModel implements EavEntityInterface
{
    use EavEntityScopeTrait;

    protected $table = self::TABLE_NAME;

    protected $fillable = self::ATTRIBUTE_FILLABLE;

    // ? Getter Modules
    public function getModelEntity(): AbstractModelInterface
    {
        return $this->__get(self::MODEL_ENTITY);
    }

    public function getEntityName(): string|null
    {
        return $this->__get(self::ATTRIBUTE_ENTITY);
    }

    public function getEntityId(): int|null
    {
        return $this->__get(self::ATTRIBUTE_ENTITYID);
    }

    public function getAttrName(): string|null
    {
        return $this->__get(self::ATTRIBUTE_NAME);
    }

    public function getAttrValue(): mixed
    {
        try {
            return unserialize($this->__get(self::ATTRIBUTE_VALUE));
        } catch (Throwable) {
            return null;
        }
    }

    // ? Setter Modules
    public function setModelEntity(AbstractModelInterface $abstractModelInterface): self
    {
        $this->__set(self::MODEL_ENTITY, $abstractModelInterface);
        $this->setEntityName($abstractModelInterface::class);
        $this->setEntityId($abstractModelInterface->getId());

        return $this;
    }

    public function setEntityName(string $entityName): self
    {
        $this->__set(self::ATTRIBUTE_ENTITY, $entityName);

        return $this;
    }

    public function setEntityId(int $entityId): self
    {
        $this->__set(self::ATTRIBUTE_ENTITYID, $entityId);

        return $this;
    }

    public function setAttrName(string $attrName): self
    {
        $this->__set(self::ATTRIBUTE_NAME, $attrName);

        return $this;
    }

    public function setAttrValue(mixed $attrValue): self
    {
        $this->__set(self::ATTRIBUTE_VALUE, serialize($attrValue));

        return $this;
    }
}
