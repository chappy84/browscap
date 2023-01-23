<?php

declare(strict_types=1);

namespace Browscap\Filter\Section;

/**
 * with this filter it is possible to combine other filters
 */
class SectionFilterCollection implements SectionFilterInterface
{
    /** @var SectionFilterInterface[] */
    private array $filters = [];

    /**
     * add a new filter to the collection
     *
     * @throws void
     */
    public function addFilter(SectionFilterInterface $writer): void
    {
        $this->filters[] = $writer;
    }

    /**
     * checks if a section should be in the output
     *
     * @param bool[] $section
     */
    public function isOutput(array $section): bool
    {
        foreach ($this->filters as $filter) {
            if (! $filter->isOutput($section)) {
                return false;
            }
        }

        return true;
    }
}
