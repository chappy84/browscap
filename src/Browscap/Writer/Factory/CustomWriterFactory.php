<?php

declare(strict_types=1);

namespace Browscap\Writer\Factory;

use Browscap\Data\PropertyHolder;
use Browscap\Filter\Division\StandardDivisionFilter;
use Browscap\Filter\FilterTypes;
use Browscap\Filter\Property\FieldPropertyFilter;
use Browscap\Filter\Section\StandardSectionFilter;
use Browscap\Formatter;
use Browscap\Formatter\FormatterInterface;
use Browscap\Writer;
use Browscap\Writer\WriterCollection;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * a factory to create a writer collection to write a custom browscap file
 */
class CustomWriterFactory
{
    /**
     * @param array<string> $fields
     *
     * @throws InvalidArgumentException
     */
    public function createCollection(
        LoggerInterface $logger,
        string $buildFolder,
        string|null $file = null,
        array $fields = [],
        string $format = FormatterInterface::TYPE_PHP,
    ): WriterCollection {
        $writerCollection = new WriterCollection();
        $propertyHolder   = new PropertyHolder();

        if ($file === null) {
            switch ($format) {
                case FormatterInterface::TYPE_ASP:
                    $file = $buildFolder . '/full_browscap.ini';

                    break;
                case FormatterInterface::TYPE_CSV:
                    $file = $buildFolder . '/browscap.csv';

                    break;
                case FormatterInterface::TYPE_XML:
                    $file = $buildFolder . '/browscap.xml';

                    break;
                case FormatterInterface::TYPE_JSON:
                    $file = $buildFolder . '/browscap.json';

                    break;
                case FormatterInterface::TYPE_PHP:
                default:
                    $file = $buildFolder . '/full_php_browscap.ini';

                    break;
            }
        }

        $divisionFilter = new StandardDivisionFilter();
        $propertyFilter = new FieldPropertyFilter($propertyHolder, $fields);
        $sectionFilter  = new StandardSectionFilter();

        switch ($format) {
            case FormatterInterface::TYPE_ASP:
                $writer    = new Writer\IniWriter($file, $logger);
                $formatter = new Formatter\AspFormatter($propertyHolder);

                break;
            case FormatterInterface::TYPE_CSV:
                $writer    = new Writer\CsvWriter($file, $logger);
                $formatter = new Formatter\CsvFormatter($propertyHolder);

                break;
            case FormatterInterface::TYPE_XML:
                $writer    = new Writer\XmlWriter($file, $logger);
                $formatter = new Formatter\XmlFormatter($propertyHolder);

                break;
            case FormatterInterface::TYPE_JSON:
                $writer    = new Writer\JsonWriter($file, $logger);
                $formatter = new Formatter\JsonFormatter($propertyHolder);

                break;
            case FormatterInterface::TYPE_PHP:
            default:
                $writer    = new Writer\IniWriter($file, $logger);
                $formatter = new Formatter\PhpFormatter($propertyHolder);

                break;
        }

        $writer->setFormatter($formatter);
        $writer->setDivisionFilter($divisionFilter);
        $writer->setSectionFilter($sectionFilter);
        $writer->setPropertyFilter($propertyFilter);
        $writer->setFilterType(FilterTypes::TYPE_CUSTOM);

        $writerCollection->addWriter($writer);

        return $writerCollection;
    }
}
