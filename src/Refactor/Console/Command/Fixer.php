<?php
namespace Refactor\Console\Command;

use Refactor\App\Repository;
use Refactor\Cache\GarbageCollector;
use Refactor\Command\Refactor;
use Refactor\Console\Animal;
use Refactor\Console\Signature;
use Refactor\Exception\FileNotFoundException;
use Refactor\Exception\UnknownVcsTypeException;
use Refactor\Exception\WrongVcsTypeException;
use Refactor\Troll\Fuck;
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
class Fixer implements CommandInterface
{
    /** @var Animal */
    private $animal;

    /** @var ApplicationValidator */
    private $applicationValidator;

    /** @var Finder */
    private $finder;

    /** @var Fuck */
    private $fuck;

    /** @var GarbageCollector */
    private $garbageCollector;

    /** @var Refactor */
    private $refactorCommand;

    /** @var Repository */
    private $repository;

    public function __construct()
    {
        $this->animal = new Animal();
        $this->applicationValidator = new ApplicationValidator();
        $this->finder = new Finder();
        $this->fuck = new Fuck();
        $this->garbageCollector = new GarbageCollector();
        $this->refactorCommand = new Refactor();
        $this->repository = new Repository();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @param array|null $parameters
     * @throws FileNotFoundException
     * @throws UnknownVcsTypeException
     * @throws WrongVcsTypeException
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters = null): void
    {
        if (!$this->applicationValidator->validate()) {
            $output->writeln('<question> ' . $this->fuck->shoutTo($this->repository->getUserName(), Signature::noob()) . ' </question>');

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
        $this->runRefactor($files, new ConsoleOutput());
    }

    /**
     * @param array $files
     * @param OutputInterface $output
     * @throws FileNotFoundException
     */
    private function runRefactor(array $files, OutputInterface $output): void
    {
        if (empty($files)) {
            $output->writeln('<comment>There are no files yet to refactor!</comment>');
            $output->writeln('<question> ' . $this->fuck->speakTo($this->repository->getUserName(), Signature::noob()) . ' </question>');

            return;
        }

        $output->writeln("<info>Refactoring...\n</info>");

        $progressBar = new ProgressBar($output, count($files));
        $progressBar->start();

        foreach ($files as $file) {
            $process = Process::fromShellCommandline(implode(' ', $this->refactorCommand->getCommand($file)));
            $process->run();

            if ($process->isSuccessful()) {
                $output->writeln('<info> ' . $file . '</info>');
            } else {
                $output->writeln('<error>' . $process->getOutput() . '</error>');
                $output->writeln('<question> ' . $this->fuck->speakFrom(Signature::team()) . ' </question>');
            }

            $progressBar->advance();
        }

        $this->cleanUp();
        $progressBar->finish();

        $output->writeln('');
        $output->writeln('<info>' . $this->animal->speak("All done... \nYour code has been refactored!") . '</info>');
        $output->writeln('<info>' . Signature::write() . '</info>');
    }

    /**
     * Removes the php cs cache file
     */
    private function cleanUp(): void
    {
        $this->garbageCollector->removeCache();
    }
}
