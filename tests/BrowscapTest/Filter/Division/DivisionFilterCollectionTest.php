<?php

declare(strict_types=1);

namespace BrowscapTest\Filter\Division;

use Browscap\Data\Division as DataDivision;
use Browscap\Filter\Division\DivisionFilterCollection;
use Browscap\Filter\Division\DivisionFilterInterface;
use PHPUnit\Framework\MockObject\MethodCannotBeConfiguredException;
use PHPUnit\Framework\MockObject\MethodNameAlreadyConfiguredException;
use PHPUnit\Framework\TestCase;

class DivisionFilterCollectionTest extends TestCase
{
    /**
     * tests setting and getting a writer
     *
     * @throws MethodNameAlreadyConfiguredException
     * @throws MethodCannotBeConfiguredException
     */
    public function testAddFilterAndIsSilent(): void
    {
        $object = new DivisionFilterCollection();

        $division = $this->createMock(DataDivision::class);

        $mockFilter = $this->createMock(DivisionFilterInterface::class);
        $mockFilter
            ->expects(static::once())
            ->method('isOutput')
            ->with($division)
            ->willReturn(true);

        $object->addFilter($mockFilter);

        static::assertTrue($object->isOutput($division));
    }
}
