<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Traits\Models;

use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use TheBachtiarz\EAV\Interfaces\Models\EavEntityInterface;

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
        return $builder->where(
            column: EavEntityInterface::ATTRIBUTE_ENTITY,
            operator: '=',
            value: $entityName,
        );
    }

    /**
     * Get by entity id
     */
    public function scopeGetByEntityId(
        EloquentBuilder|QueryBuilder $builder,
        int $entityId,
    ): BuilderContract {
        return $builder->where(
            column: EavEntityInterface::ATTRIBUTE_ENTITYID,
            operator: '=',
            value: $entityId,
        );
    }

    /**
     * Get by attribute name
     */
    public function scopeGetByAttributeName(
        EloquentBuilder|QueryBuilder $builder,
        string $attributeName,
    ): BuilderContract {
        return $builder->where(
            column: EavEntityInterface::ATTRIBUTE_NAME,
            operator: '=',
            value: $attributeName,
        );
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
        return $builder->where(
            column: EavEntityInterface::ATTRIBUTE_ENTITY,
            operator: '=',
            value: $entityName,
        )->where(
            column: EavEntityInterface::ATTRIBUTE_NAME,
            operator: '=',
            value: $attributeName,
        )->where(
            column: EavEntityInterface::ATTRIBUTE_VALUE,
            operator: 'like',
            value: "%$attributeValue%",
        );
    }
}
