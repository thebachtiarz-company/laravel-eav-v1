<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Models;

use Exception;
use TheBachtiarz\Base\App\Models\AbstractModel as BaseAbstractModel;
use TheBachtiarz\EAV\Services\EavAttributeService;

use function in_array;
use function sprintf;
use function tbgetmodelcolumns;

abstract class AbstractModel extends BaseAbstractModel
{
    use EavAttributeService;

    /**
     * List of restricted eav
     *
     * @var array
     */
    protected array $restrictedEavattributes = [];

    /**
     * Constructor
     */
    public function __construct(array $attributes = [])
    {
        $this->restrictedEavattributes = tbgetmodelcolumns($this);

        parent::__construct($attributes);
    }

    public function setData(string $attribute, mixed $value): static
    {
        if (in_array($attribute, $this->restrictedEavattributes)) {
            throw new Exception(sprintf("Attribute '%s' is restricted", $attribute));
        }

        return parent::setData($attribute, $value);
    }
}
