<?php

declare(strict_types=1);

namespace Browscap\Command;

use Browscap\Helper\LoggerHelper;
use Ergebnis\Json\Normalizer;
use Ergebnis\Json\Normalizer\Exception\InvalidIndentSize;
use Ergebnis\Json\Normalizer\Exception\InvalidIndentStyle;
use Ergebnis\Json\Normalizer\Exception\InvalidJsonEncodeOptions;
use Ergebnis\Json\Normalizer\Exception\InvalidNewLineString;
use Ergebnis\Json\Printer\Printer;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;
use Throwable;

use function file_put_contents;

use const JSON_PRETTY_PRINT;
use const JSON_UNESCAPED_SLASHES;
use const JSON_UNESCAPED_UNICODE;

class RewriteTestFixturesCommand extends Command
{
    /** @throws InvalidArgumentException */
    protected function configure(): void
    {
        $this
            ->setName('rewrite-test-fixtures')
            ->setDescription('rewrites the test files in the fixtures folder');
    }

    /**
     * @return int 0 if everything went fine, or an error code
     *
     * @throws DirectoryNotFoundException
     * @throws InvalidNewLineString
     * @throws InvalidIndentStyle
     * @throws InvalidIndentSize
     * @throws InvalidJsonEncodeOptions
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $loggerHelper = new LoggerHelper();
        $logger       = $loggerHelper->create($output);

        $resourcePath = __DIR__ . '/../../../tests/fixtures';

        $normalizer = new Normalizer\WithFinalNewLineNormalizer();
        $format     = Normalizer\Format\Format::create(
            Normalizer\Format\JsonEncodeOptions::fromInt(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            Normalizer\Format\Indent::fromSizeAndStyle(2, 'space'),
            Normalizer\Format\NewLine::fromString("\n"),
            true,
        );

        $printer   = new Printer();
        $formatter = new Normalizer\Format\DefaultFormatter($printer);

        $finder = new Finder();
        $finder->files();
        $finder->name('*.json');
        $finder->ignoreDotFiles(true);
        $finder->ignoreVCS(true);
        $finder->sortByName();
        $finder->ignoreUnreadableDirs();
        $finder->in($resourcePath);

        foreach ($finder as $file) {
            $logger->info('read source file ' . $file->getPathname());

            try {
                $json = $file->getContents();
            } catch (RuntimeException $e) {
                $logger->critical(
                    'File "{File}" is not readable',
                    [
                        'File' => $file->getPathname(),
                        'Exception' => $e,
                    ],
                );

                continue;
            }

            try {
                $normalized = (new Normalizer\FixedFormatNormalizer($normalizer, $format, $formatter))->normalize(Normalizer\Json::fromEncoded($json));
            } catch (Throwable $e) {
                $logger->critical(
                    'File "{File}" is not valid',
                    [
                        'File' => $file->getPathname(),
                        'Exception' => $e,
                    ],
                );

                continue;
            }

            file_put_contents($file->getPathname(), $normalized);
        }

        $output->writeln('Done');

        return self::SUCCESS;
    }
}
