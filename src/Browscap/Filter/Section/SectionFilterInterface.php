<?php

declare(strict_types=1);

namespace Browscap\Filter\Section;

interface SectionFilterInterface
{
    /**
     * checks if a section should be in the output
     *
     * @param bool[] $section
     *
     * @throws void
     */
    public function isOutput(array $section): bool;
}
