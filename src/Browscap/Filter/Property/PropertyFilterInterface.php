<?php

declare(strict_types=1);

namespace Browscap\Filter\Property;

use Browscap\Writer\WriterInterface;

interface PropertyFilterInterface
{
    /**
     * checks if a property should be in the output
     *
     * @throws void
     */
    public function isOutput(string $property, WriterInterface $writer): bool;
}
