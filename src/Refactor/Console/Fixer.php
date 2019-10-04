<?php
namespace Refactor\Console;

use Refactor\Command\RefactorCommand;
use Refactor\Common\CommandInterface;
use Refactor\Exception\FileNotFoundException;
use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;
use Refactor\Common\CommandInterface;
use Refactor\Common\NotifierInterface;
use Refactor\Config\Rules;
use Refactor\Exception\FileNotFoundException;
use Refactor\Utility\PathUtility;

/**
 * Class Fixer
 * @package Refactor\Fixer
 */

class Fixer extends PushCommand implements CommandInterface
{
    /** @var Animal */
    private $animal;

    /** @var Finder */
    private $finder;

    /** @var GarbageCollector */
    private $garbageCollector;

    /** @var RefactorCommand */
    private $refactorCommand;

    public function __construct()
    {
        $this->animal = new Animal();
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
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters = null)
    {
        $this->runRefactor(
            $this->finder->findAdjustedFiles(),
            $output
        );
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

        $this->pushNotification(
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

    /**
     * @param string $title
     * @param string $body
     * @param bool $exception
     */
    public function pushNotification(string $title, string $body, bool $exception): void
    {
        $notifier = NotifierFactory::create();
        $notification = new Notification();
        $notification
            ->setTitle($title)
            ->setBody($body)
            ->setIcon($exception ? NotifierInterface::SUCCESS_ICON : NotifierInterface::FAIL_ICON);

        $notifier->send($notification);
    }
}
