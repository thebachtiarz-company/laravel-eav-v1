<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Repositories;

use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\Base\App\Interfaces\Model\AbstractModelInterface;
use TheBachtiarz\Base\App\Repositories\AbstractRepository as BaseAbstractRepository;
use TheBachtiarz\EAV\Traits\Service\EavMutatorTrait;

use function collect;
use function in_array;
use function tbgetmodelcolumns;

abstract class AbstractRepository extends BaseAbstractRepository
{
    use EavMutatorTrait;

    /**
     * Set result entity using eav
     */
    protected bool $withEav = true;

    protected function createFromModel(Model $model): Model
    {
        $result = parent::createFromModel($model);

        $this->createOrUpdateEavFromModel($result);

        return $result;
    }

    protected function prepareCreate(Model $model): array
    {
        $result = parent::prepareCreate($model);

        $this->prepareEavCollection($model);

        return $result;
    }

    /**
     * Create or update attributes in entity
     */
    protected function createOrUpdateEavFromModel(Model|AbstractModelInterface $modelEntity): void
    {
        if (! collect($this->modelExtensionAttributes)->count()) {
            return;
        }

        foreach ($this->modelExtensionAttributes ?? [] as $attribute => $value) {
            $this->createOrUpdateEav($modelEntity, $attribute, $value);
        }
    }

    /**
     * Prepare eav collection
     *
     * @return array
     */
    protected function prepareEavCollection(Model|AbstractModelInterface $modelEntity): array
    {
        $modelDescColumns = tbgetmodelcolumns($modelEntity);

        foreach ($modelEntity->toArray() as $attribute => $value) {
            if (in_array($attribute, $modelDescColumns)) {
                continue;
            }

            $this->modelExtensionAttributes[$attribute] = $value;
        }

        return $this->modelExtensionAttributes;
    }

    /**
     * Save eav collection before model save
     */
    protected function saveEavBeforeModelSave(Model|AbstractModelInterface $modelEntity): Model|AbstractModelInterface
    {
        $this->prepareCreate($modelEntity);
        $this->createOrUpdateEavFromModel($modelEntity);
        $this->modelData[$modelEntity->getKeyName()] = $modelEntity->getAttributeValue($modelEntity->getKeyName());

        return $modelEntity->setRawAttributes($this->modelData);
    }

    /**
     * Set with eav
     */
    public function withEav(bool $withEav = true): static
    {
        $this->withEav = $withEav;

        return $this;
    }
}
