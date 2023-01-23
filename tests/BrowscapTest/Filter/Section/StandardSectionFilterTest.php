<?php

declare(strict_types=1);

namespace BrowscapTest\Filter\Section;

use Browscap\Filter\Section\StandardSectionFilter;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

class StandardSectionFilterTest extends TestCase
{
    /**
     * tests if a section is always in the output
     *
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    public function testIsOutputAlways(): void
    {
        $object = new StandardSectionFilter();

        static::assertTrue($object->isOutput([]));
        static::assertFalse($object->isOutput(['standard' => false]));
        static::assertTrue($object->isOutput(['standard' => true]));
    }
}
