<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Traits\Services;

use Illuminate\Support\Str;
use TheBachtiarz\Base\App\Interfaces\Models\AbstractModelInterface;
use TheBachtiarz\Base\App\Libraries\Log\LogLibrary;
use TheBachtiarz\EAV\Interfaces\Models\EavEntityInterface;
use TheBachtiarz\EAV\Models\EavEntity;
use TheBachtiarz\EAV\Repositories\EavEntityRepository;
use Throwable;

use function app;
use function assert;

/**
 * Eav Mutator Trait
 */
trait EavMutatorTrait
{
    /**
     * Model extension attributes
     *
     * @var array
     */
    protected array $modelExtensionAttributes = [];

    /**
     * Create or update EAV entity
     */
    protected function createOrUpdateEav(
        AbstractModelInterface $abstractModelInterface,
        string $attributeName,
        mixed $attributeValue,
    ): bool {
        try {
            $attributeName = Str::slug(title: $attributeName, separator: '_');

            $eavEntityRepository = app(EavEntityRepository::class);
            assert($eavEntityRepository instanceof EavEntityRepository);

            $eavEntity = $eavEntityRepository->getEntityAttributeValue($abstractModelInterface, $attributeName);
            assert($eavEntity instanceof EavEntityInterface || $eavEntity === null);

            PROCESS_UPDATE:
            if ($eavEntity?->getId()) {
                $eavEntity->setAttrValue($attributeValue);
                $eavEntityRepository->save($eavEntity);
                goto RESULT;
            }

            PROCESS_CREATE:
            $eavEntityPrepare = (new EavEntity())
                ->setModelEntity($abstractModelInterface)
                ->setAttrName($attributeName)
                ->setAttrValue($attributeValue);
            assert($eavEntityPrepare instanceof EavEntityInterface);
            $eavEntityRepository->create($eavEntityPrepare);

            RESULT:

            return true;
        } catch (Throwable $th) {
            /** @var LogLibrary @logLibrary */
            $logLibrary = app()->make(LogLibrary::class);
            $logLibrary->log(
                logEntity: $th,
                channel: match (tbconfig(configName: 'app', keyName: 'env')) {
                    'local' => 'developer',
                    'production' => 'production',
                    default => 'developer'
                }
            );

            return false;
        }
    }
}
