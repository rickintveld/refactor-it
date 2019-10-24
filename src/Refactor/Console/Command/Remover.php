<?php
namespace Refactor\Console\Command;

use Refactor\App\Repository;
use Refactor\Console\Signature;
use Refactor\Troll\Fuck;
use Refactor\Utility\PathUtility;
use Refactor\Validator\ApplicationValidator;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class Remover
 * @package Refactor\Console
 * @codeCoverageIgnore
 */
class Remover implements CommandInterface
{
    /** @var ApplicationValidator */
    private $applicationValidator;

    /** @var Fuck */
    private $fuck;

    /** @var Repository */
    private $repository;

    public function __construct()
    {
        $this->applicationValidator = new ApplicationValidator();
        $this->fuck = new Fuck();
        $this->repository = new Repository();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @param array ...$parameters
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters = null): void
    {
        if (!$this->applicationValidator->validate()) {
            $output->writeln('<question> ' . $this->fuck->shoutTo($this->repository->getUserName(), Signature::noob()) . ' </question>');

            return;
        }

        /** @var QuestionHelper $helper */
        $helper = $helperSet->get('question');
        $question = new ConfirmationQuestion('Are you sure you want to remove refactor-it from your project (y/N)?', false);

        if ($helper->ask($input, $output, $question)) {
            $output->writeln('<info>Removing the refactor-it folder and files...</info>');

            if ($this->removeFilesAndDirectory($output) === true) {
                $output->writeln('<info> The refactor-it folder and files are removed from the project!</info>');
            } else {
                $output->writeln('<error>Something went wrong while removing the refactor-it folder! Please try again...</error>');
                $output->writeln('<question> ' . $this->fuck->speakTo($this->repository->getUserName(), Signature::noob()) . ' </question>');
            }

            if ($this->cleanUpPrivateDirectory() === true) {
                $output->writeln('<info> The private folder was empty so the folder is removed from your project!</info>');
                $output->writeln('<question> ' . $this->fuck->speakFrom(Signature::team()) . ' </question>');
            } else {
                $output->writeln('<error>Something went wrong while removing the private folder! Please try again...</error>');
                $output->writeln('<question> ' . $this->fuck->speakTo($this->repository->getUserName()) . ' </question>');
            }
        }
    }

    /**
     * @param OutputInterface $output
     * @return bool
     */
    private function removeFilesAndDirectory(OutputInterface $output): bool
    {
        $folder = PathUtility::getRefactorItPath();
        $files = array_diff(scandir($folder), ['.', '..']);
        $progressBar = new ProgressBar($output, count($files) + 1);
        $progressBar->start();

        foreach ($files as $file) {
            $output->writeln('<info> ' . $folder . $file . '</info>');
            unlink($folder . '/' . $file);
            $progressBar->advance();
        }

        $output->writeln('<info> ' . $folder . '</info>');
        $progressBar->advance();
        $progressBar->finish();

        return rmdir($folder);
    }

    /**
     * @return bool
     */
    private function cleanUpPrivateDirectory(): bool
    {
        $folder = PathUtility::getPrivatePath();
        $files = array_diff(scandir($folder), ['.', '..']);

        if (count($files) > 0) {
            return false;
        }

        return rmdir($folder);
    }
}
