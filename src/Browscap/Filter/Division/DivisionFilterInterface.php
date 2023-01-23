<?php

declare(strict_types=1);

namespace Browscap\Filter\Division;

use Browscap\Data\Division as DataDivision;

interface DivisionFilterInterface
{
    /**
     * checks if a division should be in the output
     *
     * @throws void
     */
    public function isOutput(DataDivision $division): bool;
}
