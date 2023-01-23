<?php

declare(strict_types=1);

namespace BrowscapTest\Filter\Section;

use Browscap\Filter\Section\SectionFilterCollection;
use Browscap\Filter\Section\SectionFilterInterface;
use PHPUnit\Framework\MockObject\MethodCannotBeConfiguredException;
use PHPUnit\Framework\MockObject\MethodNameAlreadyConfiguredException;
use PHPUnit\Framework\TestCase;

class SectionFilterCollectionTest extends TestCase
{
    /**
     * tests setting and getting a writer
     *
     * @throws MethodNameAlreadyConfiguredException
     * @throws MethodCannotBeConfiguredException
     */
    public function testAddFilterAndIsOutput(): void
    {
        $object = new SectionFilterCollection();

        $section = [];

        $mockFilter = $this->createMock(SectionFilterInterface::class);
        $mockFilter
            ->expects(static::once())
            ->method('isOutput')
            ->with($section)
            ->willReturn(true);

        $object->addFilter($mockFilter);

        static::assertTrue($object->isOutput($section));
    }
}
