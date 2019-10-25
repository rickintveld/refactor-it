<?php
namespace Refactor\Console\Command;

use Refactor\Cache\GarbageCollector;
use Refactor\Command\Refactor;
use Refactor\Console\Animal;
use Refactor\Console\Output;
use Refactor\Console\Signature;
use Refactor\Exception\FileNotFoundException;
use Refactor\Exception\UnknownVcsTypeException;
use Refactor\Exception\WrongVcsTypeException;
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
class Fixer extends OutputCommand implements CommandInterface
{
    /** @var Animal */
    private $animal;

    /** @var ApplicationValidator */
    private $applicationValidator;

    /** @var Finder */
    private $finder;

    /** @var GarbageCollector */
    private $garbageCollector;

    /** @var Refactor */
    private $refactorCommand;

    public function __construct()
    {
        $this->animal = new Animal();
        $this->applicationValidator = new ApplicationValidator();
        $this->finder = new Finder();
        $this->garbageCollector = new GarbageCollector();
        $this->refactorCommand = new Refactor();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @param array|null $parameters
     * @throws FileNotFoundException
     * @throws UnknownVcsTypeException
     * @throws WrongVcsTypeException
     * @throws \Refactor\Exception\InvalidInputException
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters = null): void
    {
        $this->setOutput($output);

        if (!$this->applicationValidator->validate()) {
            $this->getOutput()->addFuckingLine(Output::TROLL_FROM_TO)->writeLines();

            return;
        }

        $this->runRefactor($this->finder->getChangedFiles(), $output);
    }

    /**
     * @param array $files
     * @throws FileNotFoundException
     */
    public function refactorAll(array $files)
    {
        $output = new ConsoleOutput();
        $this->setOutput($output);
        $this->runRefactor($files, $output);
    }

    /**
     * @param array $files
     * @param OutputInterface $output
     * @throws FileNotFoundException
     * @throws \Exception
     */
    private function runRefactor(array $files, OutputInterface $output): void
    {
        if (empty($files)) {
            $this->getOutput()
                ->addLine('There are no files yet to refactor', Output::FORMAT_COMMENT)
                ->addFuckingLine(Output::TROLL_FROM_TO)->writeLines();

            return;
        }

        $this->getOutput()->addLine("Refactoring...\n", Output::FORMAT_QUESTION)->writeLines();

        $progressBar = new ProgressBar($output, count($files));
        $progressBar->start();

        $failures = 0;
        foreach ($files as $file) {
            $process = Process::fromShellCommandline(implode(' ', $this->refactorCommand->getCommand($file)));
            $process->run();

            if ($process->isSuccessful()) {
                $this->getOutput()->addLine($file, Output::FORMAT_INFO)->writeLines();
            } else {
                $this->getOutput()->addLine($process->getOutput(), Output::FORMAT_INFO)->writeLines();
                $failures++;
            }

            $progressBar->advance();
        }

        $this->cleanUp();
        $progressBar->finish();

        if ($failures > 0) {
            $this->getOutput()->addFuckingLine(Output::TROLL_TO, true);
        }

        $this->getOutput()
            ->addLine($this->animal->speak("All done... \nYour code has been refactored!"), Output::FORMAT_INFO)
            ->addLine(Signature::write(), Output::FORMAT_INFO)
            ->writeLines();
    }

    /**
     * Removes the php cs cache file
     */
    private function cleanUp(): void
    {
        $this->garbageCollector->removeCache();
    }
}
