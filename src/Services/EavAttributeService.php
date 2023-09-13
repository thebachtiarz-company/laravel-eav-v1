<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Services;

use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\Base\App\Interfaces\Models\AbstractModelInterface;
use TheBachtiarz\EAV\Interfaces\Models\Data\EntityAttributeValueCollectionInterface;
use TheBachtiarz\EAV\Interfaces\Models\EavEntityInterface;
use TheBachtiarz\EAV\Models\Data\EntityAttributeValueCollection;
use TheBachtiarz\EAV\Repositories\EavEntityRepository;
use TheBachtiarz\EAV\Traits\Services\EavMutatorTrait;

use function app;
use function assert;
use function collect;

/**
 * Eav Attribute Service
 */
trait EavAttributeService
{
    use EavMutatorTrait;

    /**
     * Model Entity
     */
    protected AbstractModelInterface|Model $model;

    // ? Public Methods

    /**
     * Get extension attributes
     */
    public function getExtensionAttributes(): EntityAttributeValueCollectionInterface
    {
        /** @var AbstractModelInterface|Model $this */
        $this->model = $this;

        $eavEntityRepository = app(EavEntityRepository::class);
        assert($eavEntityRepository instanceof EavEntityRepository);

        $entityCollection = $eavEntityRepository->getAttributesEntity($this->model);

        foreach ($entityCollection->all() ?? [] as $key => $eavEntity) {
            assert($eavEntity instanceof EavEntityInterface);
            $this->modelExtensionAttributes[$eavEntity->getAttrName()] = $eavEntity->getAttrValue();
        }

        return new EntityAttributeValueCollection($this->modelExtensionAttributes);
    }

    /**
     * Return entity result with extension attributes
     *
     * @return static
     */
    public function withExtensionAttributes(): static
    {
        $extensionAttributes = $this->getExtensionAttributes();

        /** @var Model $this */

        foreach ($extensionAttributes->getData() as $attribute => $value) {
            $this->setAttribute($attribute, $value);
        }

        return $this;
    }

    /**
     * Set extension attributes
     *
     * @return static
     */
    public function setExtensionAttributes(
        EntityAttributeValueCollectionInterface $entityAttributeValueCollectionInterface,
    ): static {
        /** @var AbstractModelInterface|Model $this */
        $this->model = $this;

        $this->modelExtensionAttributes = $entityAttributeValueCollectionInterface->getData();

        return $this;
    }

    /**
     * Set extension attribute
     */
    public function setEavAttribute(string $attributeName, mixed $value): static
    {
        $this->modelExtensionAttributes[$attributeName] = $value;

        return $this;
    }

    /**
     * Create or update extension attributes
     */
    public function saveExtensionAttributes(): EntityAttributeValueCollectionInterface
    {
        /** @var AbstractModelInterface|Model $this */
        $this->model = $this;

        if (! collect($this->modelExtensionAttributes)->count()) {
            return new EntityAttributeValueCollection();
        }

        foreach ($this->modelExtensionAttributes ?? [] as $attribute => $value) {
            $this->createOrUpdateEav($this->model, $attribute, $value);
        }

        return $this->getExtensionAttributes();
    }

    /**
     * Delete extension attribute
     *
     * @return static
     */
    public function deleteEavAttribute(string $attributeName): static
    {
        /** @var AbstractModelInterface|Model $this */
        $this->model = $this;

        $eavEntityRepository = app(EavEntityRepository::class);
        assert($eavEntityRepository instanceof EavEntityRepository);

        $eavEntity = $eavEntityRepository->getEntityAttributeValue(
            abstractModelInterface: $this->model,
            attributeName: $attributeName,
        );
        assert($eavEntity instanceof EavEntityInterface || $eavEntity === null);

        if ($eavEntity?->getId()) {
            $eavEntityRepository->deleteById($eavEntity->getId());
        }

        $this->model->offsetUnset($attributeName);

        return $this;
    }
}
