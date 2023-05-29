<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Interfaces\Model;

use TheBachtiarz\Base\App\Interfaces\Model\AbstractModelInterface;

interface EavEntityInterface extends AbstractModelInterface
{
    public const TABLE_NAME = 'eav_entities';

    public const ATTRIBUTE_FILLABLE = [
        self::ATTRIBUTE_ENTITY,
        self::ATTRIBUTE_ENTITYID,
        self::ATTRIBUTE_NAME,
        self::ATTRIBUTE_VALUE,
    ];

    public const MODEL_ENTITY = 'model';

    public const ATTRIBUTE_ENTITY   = 'entity';
    public const ATTRIBUTE_ENTITYID = 'entity_id';
    public const ATTRIBUTE_NAME     = 'name';
    public const ATTRIBUTE_VALUE    = 'value';

    // ? Getter Modules

    /**
     * Get model entity
     */
    public function getModelEntity(): AbstractModelInterface;

    /**
     * Get entity name
     */
    public function getEntityName(): string|null;

    /**
     * Get entity id
     */
    public function getEntityId(): int|null;

    /**
     * Get attribute name
     */
    public function getAttrName(): string|null;

    /**
     * Get attribute value
     */
    public function getAttrValue(): mixed;

    // ? Setter Modules

    /**
     * Set model entity
     */
    public function setModelEntity(AbstractModelInterface $abstractModelInterface): self;

    /**
     * Set entity name
     */
    public function setEntityName(string $entityName): self;

    /**
     * Set entity id
     */
    public function setEntityId(int $entityId): self;

    /**
     * Set attribute name
     */
    public function setAttrName(string $attrName): self;

    /**
     * Set attribute value
     */
    public function setAttrValue(mixed $attrValue): self;
}
