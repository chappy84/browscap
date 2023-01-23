<?php

declare(strict_types=1);

namespace Browscap\Filter\Division;

use Browscap\Data\Division as DataDivision;

/**
 * with this filter it is possible to combine other filters
 */
class DivisionFilterCollection implements DivisionFilterInterface
{
    /** @var DivisionFilterInterface[] */
    private array $filters = [];

    /**
     * add a new filter to the collection
     *
     * @throws void
     */
    public function addFilter(DivisionFilterInterface $filter): void
    {
        $this->filters[] = $filter;
    }

    /**
     * checks if a division should be in the output
     */
    public function isOutput(DataDivision $division): bool
    {
        foreach ($this->filters as $filter) {
            if (! $filter->isOutput($division)) {
                return false;
            }
        }

        return true;
    }
}
