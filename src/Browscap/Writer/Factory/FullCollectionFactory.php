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
use Browscap\Formatter\AspFormatter;
use Browscap\Formatter\CsvFormatter;
use Browscap\Formatter\JsonFormatter;
use Browscap\Formatter\PhpFormatter;
use Browscap\Formatter\XmlFormatter;
use Browscap\Writer\CsvWriter;
use Browscap\Writer\IniWriter;
use Browscap\Writer\JsonWriter;
use Browscap\Writer\WriterCollection;
use Browscap\Writer\XmlWriter;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * a factory to create a writer collection to write all browscap files at once
 */
class FullCollectionFactory
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

        $aspFormatter  = new AspFormatter($propertyHolder);
        $phpFormatter  = new PhpFormatter($propertyHolder);
        $csvFormatter  = new CsvFormatter($propertyHolder);
        $xmlFormatter  = new XmlFormatter($propertyHolder);
        $jsonFormatter = new JsonFormatter($propertyHolder);

        $fullAspWriter = new IniWriter($buildFolder . '/full_asp_browscap.ini', $logger);
        $fullAspWriter->setFormatter($aspFormatter);
        $fullAspWriter->setDivisionFilter($fullDivisionFilter);
        $fullAspWriter->setSectionFilter($fullSectionFilter);
        $fullAspWriter->setPropertyFilter($fullPropertyFilter);
        $fullAspWriter->setFilterType(FilterTypes::TYPE_FULL);
        $writerCollection->addWriter($fullAspWriter);

        $fullPhpWriter = new IniWriter($buildFolder . '/full_php_browscap.ini', $logger);
        $fullPhpWriter->setFormatter($phpFormatter);
        $fullPhpWriter->setDivisionFilter($fullDivisionFilter);
        $fullPhpWriter->setSectionFilter($fullSectionFilter);
        $fullPhpWriter->setPropertyFilter($fullPropertyFilter);
        $fullPhpWriter->setFilterType(FilterTypes::TYPE_FULL);
        $writerCollection->addWriter($fullPhpWriter);

        $stdAspWriter = new IniWriter($buildFolder . '/browscap.ini', $logger);
        $stdAspWriter->setFormatter($aspFormatter);
        $stdAspWriter->setDivisionFilter($stdDivisionFilter);
        $stdAspWriter->setSectionFilter($stdSectionFilter);
        $stdAspWriter->setPropertyFilter($stdPropertyFilter);
        $stdAspWriter->setFilterType(FilterTypes::TYPE_STANDARD);
        $writerCollection->addWriter($stdAspWriter);

        $stdPhpWriter = new IniWriter($buildFolder . '/php_browscap.ini', $logger);
        $stdPhpWriter->setFormatter($phpFormatter);
        $stdPhpWriter->setDivisionFilter($stdDivisionFilter);
        $stdPhpWriter->setSectionFilter($stdSectionFilter);
        $stdPhpWriter->setPropertyFilter($stdPropertyFilter);
        $stdPhpWriter->setFilterType(FilterTypes::TYPE_STANDARD);
        $writerCollection->addWriter($stdPhpWriter);

        $liteAspWriter = new IniWriter($buildFolder . '/lite_asp_browscap.ini', $logger);
        $liteAspWriter->setFormatter($aspFormatter);
        $liteAspWriter->setDivisionFilter($liteDivisionFilter);
        $liteAspWriter->setSectionFilter($liteSectionFilter);
        $liteAspWriter->setPropertyFilter($litePropertyFilter);
        $liteAspWriter->setFilterType(FilterTypes::TYPE_LITE);
        $writerCollection->addWriter($liteAspWriter);

        $litePhpWriter = new IniWriter($buildFolder . '/lite_php_browscap.ini', $logger);
        $litePhpWriter->setFormatter($phpFormatter);
        $litePhpWriter->setDivisionFilter($liteDivisionFilter);
        $litePhpWriter->setSectionFilter($liteSectionFilter);
        $litePhpWriter->setPropertyFilter($litePropertyFilter);
        $litePhpWriter->setFilterType(FilterTypes::TYPE_LITE);
        $writerCollection->addWriter($litePhpWriter);

        $csvWriter = new CsvWriter($buildFolder . '/browscap.csv', $logger);
        $csvWriter->setFormatter($csvFormatter);
        $csvWriter->setDivisionFilter($fullDivisionFilter);
        $csvWriter->setSectionFilter($fullSectionFilter);
        $csvWriter->setPropertyFilter($fullPropertyFilter);
        $csvWriter->setFilterType(FilterTypes::TYPE_FULL);
        $writerCollection->addWriter($csvWriter);

        $xmlWriter = new XmlWriter($buildFolder . '/browscap.xml', $logger);
        $xmlWriter->setFormatter($xmlFormatter);
        $xmlWriter->setDivisionFilter($fullDivisionFilter);
        $xmlWriter->setSectionFilter($fullSectionFilter);
        $xmlWriter->setPropertyFilter($fullPropertyFilter);
        $xmlWriter->setFilterType(FilterTypes::TYPE_FULL);
        $writerCollection->addWriter($xmlWriter);

        $jsonWriter = new JsonWriter($buildFolder . '/browscap.json', $logger);
        $jsonWriter->setFormatter($jsonFormatter);
        $jsonWriter->setDivisionFilter($fullDivisionFilter);
        $jsonWriter->setSectionFilter($fullSectionFilter);
        $jsonWriter->setPropertyFilter($fullPropertyFilter);
        $jsonWriter->setFilterType(FilterTypes::TYPE_FULL);
        $writerCollection->addWriter($jsonWriter);

        $liteJsonWriter = new JsonWriter($buildFolder . '/lite_browscap.json', $logger);
        $liteJsonWriter->setFormatter($jsonFormatter);
        $liteJsonWriter->setDivisionFilter($liteDivisionFilter);
        $liteJsonWriter->setSectionFilter($liteSectionFilter);
        $liteJsonWriter->setPropertyFilter($litePropertyFilter);
        $liteJsonWriter->setFilterType(FilterTypes::TYPE_LITE);
        $writerCollection->addWriter($liteJsonWriter);

        return $writerCollection;
    }
}
