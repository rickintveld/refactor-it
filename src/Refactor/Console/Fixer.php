<?php
namespace Refactor\Console;

use Refactor\Common\CommandInterface;
use Refactor\Console\Command\NotifierCommand;
use Refactor\Console\Command\RefactorCommand;
use Refactor\Exception\FileNotFoundException;
use Refactor\Validator\ApplicationValidator;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Class Fixer
 * @package Refactor\Fixer
 */
class Fixer extends NotifierCommand implements CommandInterface
{
    /** @var Animal */
    private $animal;

    /** @var ApplicationValidator */
    private $applicationValidator;

    /** @var Finder */
    private $finder;

    /** @var GarbageCollector */
    private $garbageCollector;

    /** @var RefactorCommand */
    private $refactorCommand;

    public function __construct()
    {
        $this->animal = new Animal();
        $this->applicationValidator = new ApplicationValidator();
        $this->finder = new Finder();
        $this->garbageCollector = new GarbageCollector();
        $this->refactorCommand = new RefactorCommand();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @param array|null $parameters
     * @throws FileNotFoundException
     * @throws \Refactor\Exception\UnknownVcsTypeException
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters = null): void
    {
        if (!$this->applicationValidator->validate()) {
            return;
        }

        $this->runRefactor(
            $this->finder->findAdjustedFiles(),
            $output
        );
    }

    /**
     * @param array $files
     * @throws FileNotFoundException
     */
    public function refactorAll(array $files)
    {
        $this->runRefactor($files, new ConsoleOutput());
    }

    /**
     * @param array $files
     * @param OutputInterface $output
     * @throws FileNotFoundException
     */
    private function runRefactor(array $files, OutputInterface $output)
    {
        if (empty($files)) {
            $output->writeln('<comment>' . $this->animal->speak('There are no files yet to refactor!') . '</comment>');

            return;
        }

        $output->writeln('<info>Refactoring...</info>');
        $output->writeln('');

        $progressBar = new ProgressBar($output, count($files));
        $progressBar->start();

        foreach ($files as $file) {
            $process = Process::fromShellCommandline(implode(' ', $this->refactorCommand->getCommand($file)));
            $process->run();

            if ($process->isSuccessful()) {
                $output->writeln('<info> ' . $file . '</info>');
            } else {
                $output->writeln('<error>' . $process->getOutput() . '</error>');
            }

            $progressBar->advance();
        }

        $this->cleanUp();
        $progressBar->finish();

        $this->push(
            'Refactor complete',
            'The refactor process is completed!',
            false
        );

        $output->writeln('');
        $output->writeln('<info>' . $this->animal->speak("All done... \nYour code has been refactored!") . '</info>');
        $output->writeln('<info>' . Signature::write() . '</info>');
    }

    /**
     * Removes the php cs fixer cache file
     */
    private function cleanUp()
    {
        $this->garbageCollector->cleanUpCacheFile();
    }
}
