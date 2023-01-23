<?php

declare(strict_types=1);

namespace BrowscapTest\Filter\Property;

use Browscap\Filter\Property\PropertyFilterCollection;
use Browscap\Filter\Property\PropertyFilterInterface;
use Browscap\Writer\WriterInterface;
use PHPUnit\Framework\MockObject\MethodCannotBeConfiguredException;
use PHPUnit\Framework\MockObject\MethodNameAlreadyConfiguredException;
use PHPUnit\Framework\TestCase;

class PropertyFilterCollectionTest extends TestCase
{
    /**
     * tests setting and getting a writer
     *
     * @throws MethodNameAlreadyConfiguredException
     * @throws MethodCannotBeConfiguredException
     */
    public function testAddFilterAndIsOutputProperty(): void
    {
        $object = new PropertyFilterCollection();

        $mockWriter = $this->createMock(WriterInterface::class);
        $property   = 'test';

        $mockFilter = $this->createMock(PropertyFilterInterface::class);
        $mockFilter
            ->expects(static::once())
            ->method('isOutput')
            ->with($property, $mockWriter)
            ->willReturn(true);

        $object->addFilter($mockFilter);

        static::assertTrue($object->isOutput($property, $mockWriter));
    }
}
