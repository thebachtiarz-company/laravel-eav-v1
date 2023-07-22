<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use TheBachtiarz\Base\App\Interfaces\Models\AbstractModelInterface;
use TheBachtiarz\Base\App\Repositories\AbstractRepository;
use TheBachtiarz\EAV\Interfaces\Models\EavEntityInterface;
use TheBachtiarz\EAV\Models\EavEntity;

use function assert;

class EavEntityRepository extends AbstractRepository
{
    // ? Public Methods

    /**
     * Get attributes in model
     */
    public function getAttributesModel(AbstractModelInterface $abstractModelInterface): Collection
    {
        $collection = EavEntity::getByEntityName($abstractModelInterface::class);
        assert($collection instanceof Builder);

        return $collection->get();
    }

    /**
     * Get attributes in entity
     */
    public function getAttributesEntity(AbstractModelInterface $abstractModelInterface): Collection
    {
        $collection = EavEntity::getByEntityName($abstractModelInterface::class)
            ->getByEntityId($abstractModelInterface->getId());
        assert($collection instanceof Builder);

        return $collection->get();
    }

    /**
     * Search entities by attribute value
     */
    public function searchEntityAttribute(
        AbstractModelInterface $abstractModelInterface,
        string $attributeName,
        string $attributeValue,
    ): Collection {
        $collection = EavEntity::searchByEntityValue(
            $abstractModelInterface::class,
            $attributeName,
            $attributeValue,
        );
        assert($collection instanceof Builder);

        return $collection->get();
    }

    /**
     * Get entity attribute value
     */
    public function getEntityAttributeValue(
        AbstractModelInterface $abstractModelInterface,
        string $attributeName,
    ): EavEntityInterface|null {
        $collection = EavEntity::getByEntityName($abstractModelInterface::class)
            ->getByEntityId($abstractModelInterface->getId())
            ->getByAttributeName($attributeName);
        assert($collection instanceof Builder);

        return $collection->latest()->first();
    }

    /**
     * Create new eav
     */
    public function create(EavEntityInterface $eavEntityInterface): EavEntityInterface
    {
        /** @var Model $eavEntityInterface */
        $create = $this->createFromModel($eavEntityInterface);
        assert($create instanceof EavEntityInterface);

        if (! $create) {
            throw new ModelNotFoundException('Failed to create new entity attribute');
        }

        return $create;
    }

    /**
     * Save current eav
     */
    public function save(EavEntityInterface $eavEntityInterface): EavEntityInterface
    {
        /** @var Model|EavEntityInterface $eavEntityInterface */
        $resource = $eavEntityInterface->save();

        if (! $resource) {
            throw new ModelNotFoundException('Failed to save current entity attribute');
        }

        return $eavEntityInterface;
    }

    /**
     * Delete attributes in entity
     */
    public function deleteAttributeEntity(AbstractModelInterface $abstractModelInterface): bool
    {
        $collection = $this->getAttributesEntity($abstractModelInterface);

        if ($collection->count()) {
            foreach ($collection->all() ?? [] as $key => $eavEntity) {
                assert($eavEntity instanceof EavEntityInterface);
                $this->deleteById($eavEntity->getId());
            }

            return true;
        }

        return false;
    }

    // ? Protected Methods

    protected function getByIdErrorMessage(): string|null
    {
        return "Eav with id '%s' not found!";
    }

    protected function createOrUpdateErrorMessage(): string|null
    {
        return 'Failed to %s eav';
    }

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
