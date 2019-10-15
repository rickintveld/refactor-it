<?php
namespace Refactor\Console;

use Refactor\Common\CommandInterface;
use Refactor\Utility\PathUtility;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class Remover
 * @package Refactor\Console
 */
class Remover extends PushCommand implements CommandInterface
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @param array ...$parameters
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters = null)
    {
        if (file_exists(PathUtility::getRefactorItPath()) === false) {
            $output->writeln('<info>The refactor-it folder was not found, stopping command...</info>');

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
            }

            if ($this->cleanUpPrivateDirectory() === true) {
                $output->writeln('<info> The private folder was empty so the folder is removed from your project!</info>');
            } else {
                $output->writeln('<error>Something went wrong while removing the private folder! Please try again...</error>');
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

        $this->pushNotification(
            'Removing complete',
            'All the files and folder are deleted from your project!',
            false
        );

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
