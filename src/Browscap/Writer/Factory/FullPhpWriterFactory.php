<?php

declare(strict_types=1);

namespace Browscap\Writer\Factory;

use Browscap\Data\PropertyHolder;
use Browscap\Filter\Division\FullDivisionFilter;
use Browscap\Filter\FilterTypes;
use Browscap\Filter\Property\FullPropertyFilter;
use Browscap\Filter\Section\FullSectionFilter;
use Browscap\Formatter\PhpFormatter;
use Browscap\Writer\IniWriter;
use Browscap\Writer\WriterCollection;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * a factory to create a writer collection to write the full php browscap file
 */
class FullPhpWriterFactory
{
    /** @throws InvalidArgumentException */
    public function createCollection(LoggerInterface $logger, string $buildFolder, string|null $file = null): WriterCollection
    {
        $writerCollection = new WriterCollection();
        $propertyHolder   = new PropertyHolder();

        if ($file === null) {
            $file = $buildFolder . '/full_php_browscap.ini';
        }

        $divisionFilter = new FullDivisionFilter();
        $propertyFilter = new FullPropertyFilter($propertyHolder);
        $sectionFilter  = new FullSectionFilter();
        $fullPhpWriter  = new IniWriter($file, $logger);
        $formatter      = new PhpFormatter($propertyHolder);
        $fullPhpWriter->setFormatter($formatter);
        $fullPhpWriter->setDivisionFilter($divisionFilter);
        $fullPhpWriter->setSectionFilter($sectionFilter);
        $fullPhpWriter->setPropertyFilter($propertyFilter);
        $fullPhpWriter->setFilterType(FilterTypes::TYPE_FULL);

        $writerCollection->addWriter($fullPhpWriter);

        return $writerCollection;
    }
}
