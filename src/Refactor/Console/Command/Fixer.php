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
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Stopwatch\Stopwatch;

class Fixer extends OutputCommand implements CommandInterface
{
    private Animal $animal;
    private Finder $finder;
    private GarbageCollector $garbageCollector;
    private Refactor $refactorCommand;

    public function __construct()
    {
        parent::__construct();

        $this->animal = new Animal();
        $this->finder = new Finder();
        $this->garbageCollector = new GarbageCollector();
        $this->refactorCommand = new Refactor();
        $this->setOutput(new ConsoleOutput());
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

        $this->run($this->finder->getChangedFiles());
    }

    /**
     * @param array $files
     * @throws FileNotFoundException
     */
    public function refactorAll(array $files): void
    {
        $this->run($files);
    }

    /**
     * @param array $files
     * @throws FileNotFoundException
     * @throws \Exception
     */
    private function run(array $files): void
    {
        if (empty($files)) {
            $this->getOutput()
                ->addLine('There are no files yet to refactor', Output::FORMAT_COMMENT)
                ->addFuckingLine(Output::TROLL_FROM_TO)->writeLines();

            return;
        }

        $this->getOutput()->addLine('Start cleaning up..', Output::FORMAT_INFO)->writeLines();

        $stopwatch = new Stopwatch('Fixer');
        $stopwatch->start('Fixer');

        $failures = 0;
        foreach ($files as $file) {
            $process = Process::fromShellCommandline(implode(' ', $this->refactorCommand->execute($file)));
            $process->run();

            if ($process->isSuccessful()) {
                $this->getOutput()->addLine(sprintf('Code sniffing ==> %s', $file), Output::FORMAT_INFO)->writeLines();
            } else {
                $this->getOutput()->addLine($process->getOutput(), Output::FORMAT_INFO)->writeLines();
                $failures++;
            }
        }

        $this->cleanUp();
        $event = $stopwatch->stop('Fixer');

        if ($failures > 0) {
            $this->getOutput()->addFuckingLine(Output::TROLL_TO, true);
        }

        $this->getOutput()
            ->addLine($this->animal->speak(sprintf("All done... \nYour code has been refactored \nin %d seconds!", $event->getDuration() / 1000)), Output::FORMAT_INFO)
            ->addLine(Signature::write(), Output::FORMAT_INFO)
            ->writeLines();
    }

    private function cleanUp(): void
    {
        $this->garbageCollector->removeCache();
    }
}
