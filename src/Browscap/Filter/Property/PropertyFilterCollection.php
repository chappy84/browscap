<?php

declare(strict_types=1);

namespace Browscap\Filter\Property;

use Browscap\Writer\WriterInterface;

/**
 * with this filter it is possible to combine other filters
 */
class PropertyFilterCollection implements PropertyFilterInterface
{
    /** @var PropertyFilterInterface[] */
    private array $filters = [];

    /**
     * add a new filter to the collection
     *
     * @throws void
     */
    public function addFilter(PropertyFilterInterface $writer): void
    {
        $this->filters[] = $writer;
    }

    /**
     * checks if a property should be in the output
     */
    public function isOutput(string $property, WriterInterface $writer): bool
    {
        foreach ($this->filters as $filter) {
            if (! $filter->isOutput($property, $writer)) {
                return false;
            }
        }

        return true;
    }
}
