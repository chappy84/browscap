<?php

declare(strict_types=1);

namespace Browscap\Writer;

use Browscap\Data\DataCollection;
use Browscap\Data\Helper\TrimProperty;
use Browscap\Filter\Division\DivisionFilterInterface;
use Browscap\Filter\Property\PropertyFilterInterface;
use Browscap\Filter\Section\SectionFilterInterface;
use Browscap\Formatter\FormatterInterface;
use Exception;
use InvalidArgumentException;
use JsonException;
use Psr\Log\LoggerInterface;

use function array_keys;
use function array_merge;
use function fclose;
use function fopen;
use function fwrite;
use function is_bool;
use function sprintf;

use const PHP_EOL;

/**
 * This writer is responsible to create the browscap.ini files
 */
class IniWriter implements WriterInterface
{
    /** @var resource */
    private $file;

    private FormatterInterface $formatter;

    private DivisionFilterInterface $divisionFilter;

    private SectionFilterInterface $sectionFilter;

    private PropertyFilterInterface $propertyFilter;

    private string $filterType;

    private bool $silent = false;

    /** @var bool[] */
    private array $outputProperties = [];

    private TrimProperty $trimProperty;

    /** @throws InvalidArgumentException */
    public function __construct(string $file, private LoggerInterface $logger)
    {
        $this->trimProperty = new TrimProperty();
        $ressource          = fopen($file, 'w');

        if ($ressource === false) {
            throw new InvalidArgumentException(sprintf('An error occured while opening File: %s', $file));
        }

        $this->file = $ressource;
    }

    /**
     * returns the Type of the writer
     *
     * @throws void
     */
    public function getType(): string
    {
        return WriterInterface::TYPE_INI;
    }

    /**
     * closes the Writer and the written File
     *
     * @throws void
     */
    public function close(): void
    {
        fclose($this->file);
    }

    /** @throws void */
    public function setFormatter(FormatterInterface $formatter): void
    {
        $this->formatter = $formatter;
    }

    /** @throws void */
    public function getFormatter(): FormatterInterface
    {
        return $this->formatter;
    }

    /** @throws void */
    public function setDivisionFilter(DivisionFilterInterface $divisionFilter): void
    {
        $this->divisionFilter = $divisionFilter;
        $this->resetProperties();
    }

    /** @throws void */
    public function getDivisionFilter(): DivisionFilterInterface
    {
        return $this->divisionFilter;
    }

    /** @throws void */
    public function setSectionFilter(SectionFilterInterface $sectionFilter): void
    {
        $this->sectionFilter = $sectionFilter;
        $this->resetProperties();
    }

    /** @throws void */
    public function getSectionFilter(): SectionFilterInterface
    {
        return $this->sectionFilter;
    }

    /** @throws void */
    public function setPropertyFilter(PropertyFilterInterface $propertyFilter): void
    {
        $this->propertyFilter = $propertyFilter;
        $this->resetProperties();
    }

    /** @throws void */
    public function getPropertyFilter(): PropertyFilterInterface
    {
        return $this->propertyFilter;
    }

    /** @throws void */
    private function resetProperties(): void
    {
        $this->outputProperties = [];
    }

    /** @throws void */
    public function setFilterType(string $filterType): void
    {
        $this->filterType = $filterType;
    }

    /** @throws void */
    public function getFilterType(): string
    {
        return $this->filterType;
    }

    /** @throws void */
    public function setSilent(bool $silent): void
    {
        $this->silent = $silent;
    }

    /** @throws void */
    public function isSilent(): bool
    {
        return $this->silent;
    }

    /**
     * Generates a start sequence for the output file
     *
     * @throws void
     */
    public function fileStart(): void
    {
        // nothing to do here
    }

    /**
     * Generates a end sequence for the output file
     *
     * @throws void
     */
    public function fileEnd(): void
    {
        // nothing to do here
    }

    /**
     * Generate the header
     *
     * @param array<string> $comments
     *
     * @throws void
     */
    public function renderHeader(array $comments = []): void
    {
        if ($this->isSilent()) {
            return;
        }

        $this->logger->debug('rendering comments');

        foreach ($comments as $comment) {
            fwrite($this->file, ';;; ' . $comment . PHP_EOL);
        }

        fwrite($this->file, PHP_EOL);
    }

    /**
     * renders the version information
     *
     * @param array<string> $versionData
     *
     * @throws void
     */
    public function renderVersion(array $versionData = []): void
    {
        if ($this->isSilent()) {
            return;
        }

        $this->logger->debug('rendering version information');

        $this->renderDivisionHeader('Browscap Version');

        fwrite($this->file, '[GJK_Browscap_Version]' . PHP_EOL);

        if (! isset($versionData['version'])) {
            $versionData['version'] = '0';
        }

        if (! isset($versionData['released'])) {
            $versionData['released'] = '';
        }

        if (! isset($versionData['format'])) {
            $versionData['format'] = '';
        }

        if (! isset($versionData['type'])) {
            $versionData['type'] = '';
        }

        fwrite($this->file, 'Version=' . $versionData['version'] . PHP_EOL);
        fwrite($this->file, 'Released=' . $versionData['released'] . PHP_EOL);
        fwrite($this->file, 'Format=' . $versionData['format'] . PHP_EOL);
        fwrite($this->file, 'Type=' . $versionData['type'] . PHP_EOL . PHP_EOL);
    }

    /**
     * renders the header for all divisions
     *
     * @throws void
     */
    public function renderAllDivisionsHeader(DataCollection $collection): void
    {
        // nothing to do here
    }

    /**
     * renders the header for a division
     *
     * @throws void
     */
    public function renderDivisionHeader(string $division, string $parent = 'DefaultProperties'): void
    {
        if ($this->isSilent() || $parent !== 'DefaultProperties') {
            return;
        }

        fwrite($this->file, ';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;; ' . $division . PHP_EOL . PHP_EOL);
    }

    /**
     * renders the header for a section
     *
     * @throws void
     */
    public function renderSectionHeader(string $sectionName): void
    {
        if ($this->isSilent()) {
            return;
        }

        fwrite($this->file, '[' . $sectionName . ']' . PHP_EOL);
    }

    /**
     * renders all found useragents into a string
     *
     * @param array<string, int|string|true>            $section
     * @param array<string, array<string, bool|string>> $sections
     *
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws JsonException
     */
    public function renderSectionBody(array $section, DataCollection $collection, array $sections = [], string $sectionName = ''): void
    {
        if ($this->isSilent()) {
            return;
        }

        $division          = $collection->getDefaultProperties();
        $ua                = $division->getUserAgents()[0];
        $defaultproperties = $ua->getProperties();
        $properties        = array_merge(['Parent'], array_keys($defaultproperties));

        foreach ($defaultproperties as $propertyName => $propertyValue) {
            if (is_bool($propertyValue)) {
                $defaultproperties[$propertyName] = $propertyValue;
            } else {
                $defaultproperties[$propertyName] = $this->trimProperty->trim((string) $propertyValue);
            }
        }

        foreach ($properties as $property) {
            if (! isset($section[$property])) {
                continue;
            }

            if (! isset($this->outputProperties[$property])) {
                $this->outputProperties[$property] = $this->propertyFilter->isOutput($property, $this);
            }

            if (! $this->outputProperties[$property]) {
                continue;
            }

            if (isset($section['Parent']) && $property !== 'Parent') {
                if (
                    $section['Parent'] === 'DefaultProperties'
                    || ! isset($sections[$section['Parent']])
                ) {
                    if (
                        isset($defaultproperties[$property])
                        && $defaultproperties[$property] === $section[$property]
                    ) {
                        continue;
                    }
                } else {
                    $parentProperties = $sections[$section['Parent']];

                    if (
                        isset($parentProperties[$property])
                        && $parentProperties[$property] === $section[$property]
                    ) {
                        continue;
                    }
                }
            }

            fwrite(
                $this->file,
                $this->formatter->formatPropertyName($property)
                . '=' . $this->formatter->formatPropertyValue($section[$property], $property) . PHP_EOL,
            );
        }
    }

    /**
     * renders the footer for a section
     *
     * @throws void
     */
    public function renderSectionFooter(string $sectionName = ''): void
    {
        if ($this->isSilent()) {
            return;
        }

        fwrite($this->file, PHP_EOL);
    }

    /**
     * renders the footer for a division
     *
     * @throws void
     */
    public function renderDivisionFooter(): void
    {
        // nothing to do here
    }

    /**
     * renders the footer for all divisions
     *
     * @throws void
     */
    public function renderAllDivisionsFooter(): void
    {
        // nothing to do here
    }
}
