<?php

declare(strict_types=1);

namespace Browscap\Filter\Section;

/**
 * this filter is responsible to select properties and sections for the "full" version of the browscap files
 */
class StandardSectionFilter implements SectionFilterInterface
{
    /**
     * checks if a section should be in the output
     *
     * @param bool[] $section
     *
     * @throws void
     */
    public function isOutput(array $section): bool
    {
        return ! isset($section['standard']) || $section['standard'];
    }
}
