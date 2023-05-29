<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Traits\Model;

use Illuminate\Database\Eloquent\Builder;
use TheBachtiarz\EAV\Interfaces\Model\EavEntityInterface;

/**
 * Eav Entity Scope Trait
 */
trait EavEntityScopeTrait
{
    /**
     * Get by entity name
     */
    public function scopeGetByEntityName(Builder $builder, string $entityName): Builder
    {
        return $builder->where(EavEntityInterface::ATTRIBUTE_ENTITY, $entityName);
    }

    /**
     * Get by entity id
     */
    public function scopeGetByEntityId(Builder $builder, int $entityId): Builder
    {
        return $builder->where(EavEntityInterface::ATTRIBUTE_ENTITYID, $entityId);
    }

    /**
     * Get by attribute name
     */
    public function scopeGetByAttributeName(Builder $builder, string $attributeName): Builder
    {
        return $builder->where(EavEntityInterface::ATTRIBUTE_NAME, $attributeName);
    }

    /**
     * Search by entity attribute value
     */
    public function scopeSearchByEntityValue(
        Builder $builder,
        string $entityName,
        string $attributeName,
        string $attributeValue,
    ): Builder {
        return $builder->where(EavEntityInterface::ATTRIBUTE_ENTITY, $entityName)
            ->where(EavEntityInterface::ATTRIBUTE_NAME, $attributeName)
            ->where(EavEntityInterface::ATTRIBUTE_VALUE, 'like', "%$attributeValue%");
    }
}
