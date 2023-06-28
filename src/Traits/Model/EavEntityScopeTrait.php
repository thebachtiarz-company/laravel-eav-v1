<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Traits\Model;

use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use TheBachtiarz\EAV\Interfaces\Model\EavEntityInterface;

/**
 * Eav Entity Scope Trait
 */
trait EavEntityScopeTrait
{
    /**
     * Get by entity name
     */
    public function scopeGetByEntityName(
        EloquentBuilder|QueryBuilder $builder,
        string $entityName,
    ): BuilderContract {
        return $builder->where(EavEntityInterface::ATTRIBUTE_ENTITY, $entityName);
    }

    /**
     * Get by entity id
     */
    public function scopeGetByEntityId(
        EloquentBuilder|QueryBuilder $builder,
        int $entityId,
    ): BuilderContract {
        return $builder->where(EavEntityInterface::ATTRIBUTE_ENTITYID, $entityId);
    }

    /**
     * Get by attribute name
     */
    public function scopeGetByAttributeName(
        EloquentBuilder|QueryBuilder $builder,
        string $attributeName,
    ): BuilderContract {
        return $builder->where(EavEntityInterface::ATTRIBUTE_NAME, $attributeName);
    }

    /**
     * Search by entity attribute value
     */
    public function scopeSearchByEntityValue(
        EloquentBuilder|QueryBuilder $builder,
        string $entityName,
        string $attributeName,
        string $attributeValue,
    ): BuilderContract {
        return $builder->where(EavEntityInterface::ATTRIBUTE_ENTITY, $entityName)
            ->where(EavEntityInterface::ATTRIBUTE_NAME, $attributeName)
            ->where(EavEntityInterface::ATTRIBUTE_VALUE, 'like', "%$attributeValue%");
    }
}
