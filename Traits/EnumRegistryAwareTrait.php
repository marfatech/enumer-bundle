<?php

declare(strict_types=1);

/*
 * This file is part of the EnumerBundle package.
 *
 * (c) MarfaTech <https://marfa-tech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MarfaTech\Bundle\EnumerBundle\Traits;

use MarfaTech\Bundle\EnumerBundle\Registry\EnumRegistryService;

trait EnumRegistryAwareTrait
{
    /**
     * @var EnumRegistryService
     */
    protected $enumer;

    /**
     * @required
     *
     * @param EnumRegistryService $enumer
     */
    public function setEnumer(EnumRegistryService $enumer)
    {
        $this->enumer = $enumer;
    }
}
