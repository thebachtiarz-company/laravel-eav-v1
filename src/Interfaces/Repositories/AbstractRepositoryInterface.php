<?php

declare(strict_types=1);

namespace TheBachtiarz\EAV\Interfaces\Repositories;

use TheBachtiarz\Base\App\Interfaces\Repositories\AbstractRepositoryInterface as BaseAbstractRepositoryInterface;

interface AbstractRepositoryInterface extends BaseAbstractRepositoryInterface
{
    // ? Public Methods

    /**
     * Set is result with eav
     *
     * @param bool|null $withEav If null, it will return current value.
     *
     * @return static|bool
     */
    public function withEav(bool|null $withEav = null): static|bool;

    // ? Getter Modules

    // ? Setter Modules
}
