<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Repositories;

use Illuminate\Database\Eloquent\Model;
use TheBachtiarz\Base\App\Interfaces\Models\AbstractModelInterface;
use TheBachtiarz\Base\App\Repositories\AbstractRepository as BaseAbstractRepository;
use TheBachtiarz\EAV\Interfaces\Repositories\AbstractRepositoryInterface;
use TheBachtiarz\EAV\Traits\Services\EavMutatorTrait;

use function collect;
use function in_array;
use function is_null;
use function tbgetmodelcolumns;

abstract class AbstractRepository extends BaseAbstractRepository implements AbstractRepositoryInterface
{
    use EavMutatorTrait;

    /**
     * Set result entity using eav
     */
    protected bool $withEav = true;

    // ? Public Methods

    /**
     * Set is result with eav
     *
     * @param bool|null $withEav If null, it will return current value.
     *
     * @return static|bool
     */
    public function withEav(bool|null $withEav = null): static|bool
    {
        if (! is_null($withEav)) {
            $this->withEav = $withEav;

            return $this;
        }

        return $this->withEav;
    }

    // ? Protected Methods

    protected function createFromModel(Model|AbstractModelInterface $model): Model|AbstractModelInterface
    {
        $result = parent::createFromModel($model);

        $this->createOrUpdateEavFromModel($result);

        return $result;
    }

    protected function prepareCreate(Model|AbstractModelInterface $model): array
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

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
