<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Models;

use Exception;
use TheBachtiarz\Base\App\Models\AbstractModel as BaseAbstractModel;
use TheBachtiarz\EAV\Services\EavAttributeService;

use function in_array;
use function sprintf;
use function tbgetcolumnstablefrommodel;

abstract class AbstractModel extends BaseAbstractModel
{
    use EavAttributeService;

    /**
     * List of restricted eav
     *
     * @var array
     */
    protected array $restrictedEavattributes = [];

    public function __construct(array $attributes = [])
    {
        $this->restrictedEavattributes = tbgetcolumnstablefrommodel($this);

        parent::__construct($attributes);
    }

    public function setData(string $attribute, mixed $value): static
    {
        if (in_array($attribute, $this->restrictedEavattributes)) {
            throw new Exception(sprintf("Attribute '$attribute' is restricted"));
        }

        return parent::setData($attribute, $value);
    }
}
