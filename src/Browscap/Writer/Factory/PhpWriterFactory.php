<?php

declare(strict_types=1);

namespace Browscap\Writer\Factory;

use Browscap\Data\PropertyHolder;
use Browscap\Filter\Division\FullDivisionFilter;
use Browscap\Filter\Division\LiteDivisionFilter;
use Browscap\Filter\Division\StandardDivisionFilter;
use Browscap\Filter\FilterTypes;
use Browscap\Filter\Property\FullPropertyFilter;
use Browscap\Filter\Property\LitePropertyFilter;
use Browscap\Filter\Property\StandardPropertyFilter;
use Browscap\Filter\Section\FullSectionFilter;
use Browscap\Filter\Section\LiteSectionFilter;
use Browscap\Filter\Section\StandardSectionFilter;
use Browscap\Formatter\PhpFormatter;
use Browscap\Writer\IniWriter;
use Browscap\Writer\WriterCollection;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * a factory to create a writer collection to write all php browscap files at once
 */
class PhpWriterFactory
{
    /** @throws InvalidArgumentException */
    public function createCollection(LoggerInterface $logger, string $buildFolder): WriterCollection
    {
        $writerCollection = new WriterCollection();
        $propertyHolder   = new PropertyHolder();

        $fullDivisionFilter = new FullDivisionFilter();
        $stdDivisionFilter  = new StandardDivisionFilter();
        $liteDivisionFilter = new LiteDivisionFilter();

        $fullPropertyFilter = new FullPropertyFilter($propertyHolder);
        $stdPropertyFilter  = new StandardPropertyFilter($propertyHolder);
        $litePropertyFilter = new LitePropertyFilter($propertyHolder);

        $fullSectionFilter = new FullSectionFilter();
        $stdSectionFilter  = new StandardSectionFilter();
        $liteSectionFilter = new LiteSectionFilter();

        $formatter = new PhpFormatter($propertyHolder);

        $fullPhpWriter = new IniWriter($buildFolder . '/full_php_browscap.ini', $logger);
        $fullPhpWriter->setFormatter($formatter);
        $fullPhpWriter->setDivisionFilter($fullDivisionFilter);
        $fullPhpWriter->setSectionFilter($fullSectionFilter);
        $fullPhpWriter->setPropertyFilter($fullPropertyFilter);
        $fullPhpWriter->setFilterType(FilterTypes::TYPE_FULL);
        $writerCollection->addWriter($fullPhpWriter);

        $stdPhpWriter = new IniWriter($buildFolder . '/php_browscap.ini', $logger);
        $stdPhpWriter->setFormatter($formatter);
        $stdPhpWriter->setDivisionFilter($stdDivisionFilter);
        $stdPhpWriter->setSectionFilter($stdSectionFilter);
        $stdPhpWriter->setPropertyFilter($stdPropertyFilter);
        $stdPhpWriter->setFilterType(FilterTypes::TYPE_STANDARD);
        $writerCollection->addWriter($stdPhpWriter);

        $litePhpWriter = new IniWriter($buildFolder . '/lite_php_browscap.ini', $logger);
        $litePhpWriter->setFormatter($formatter);
        $litePhpWriter->setDivisionFilter($liteDivisionFilter);
        $litePhpWriter->setSectionFilter($liteSectionFilter);
        $litePhpWriter->setPropertyFilter($litePropertyFilter);
        $litePhpWriter->setFilterType(FilterTypes::TYPE_LITE);
        $writerCollection->addWriter($litePhpWriter);

        return $writerCollection;
    }
}
