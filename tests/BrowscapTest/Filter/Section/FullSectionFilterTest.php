<?php

declare(strict_types=1);

namespace BrowscapTest\Filter\Section;

use Browscap\Filter\Section\FullSectionFilter;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

class FullSectionFilterTest extends TestCase
{
    /**
     * tests if a section is always in the output
     *
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testIsOutputAlways(): void
    {
        $object = new FullSectionFilter();

        static::assertTrue($object->isOutput([]));
        static::assertTrue($object->isOutput(['full' => false]));
        static::assertTrue($object->isOutput(['full' => true]));
    }
}
