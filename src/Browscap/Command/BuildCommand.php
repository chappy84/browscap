<?php

namespace Browscap\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Browscap\Generator\BrowscapIniGenerator;
use Symfony\Component\Console\Input\InputArgument;

/**
 * @author James Titcumb <james@asgrim.com>
 */
class BuildCommand extends Command
{
    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * @var string
     */
    protected $resourceFolder;

    /**
     * @var string
     */
    protected $buildFolder;

    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this
            ->setName('build')
            ->setDescription('The JSON source files and builds the INI files')
            ->addArgument('version', InputArgument::REQUIRED, "Version number to apply")
        ;
    }

    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->resourceFolder = './resources';
        $this->buildFolder = __DIR__ . '/../../../build';
        $version = $input->getArgument('version');

        $generator = new BrowscapIniGenerator($version);
        $generator->addPlatformsFile($this->resourceFolder . '/platforms.json');

        $uaSourceDirectory = $this->resourceFolder . '/user-agents';

        $iterator = new \RecursiveDirectoryIterator($uaSourceDirectory);

        foreach (new \RecursiveIteratorIterator($iterator) as $file) {
        	if (!$file->isFile() || $file->getExtension() != 'json') continue;

        	$msg = sprintf('<info>Processing file %s ...</info>', $file->getPathname());
        	$this->output->writeln($msg);
        	$generator->addSourceFile($file->getPathname());
        }

        $formats = array(
            ['browscapTest_asp_full.ini', 'ASP/FULL', false],
            ['browscapTest_php_full.ini', 'PHP/FULL', true],
        );

        foreach ($formats as $format) {
            $this->output->writeln('<info>Generating ' . $format[0] . ' [' . $format[1] . ']</info>');
            file_put_contents($this->buildFolder . '/' . $format[0], $generator->generateBrowscapIni($format[2]));
        }

        $this->output->writeln('<info>All done.</info>');
    }

}
