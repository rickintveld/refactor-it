<?php
namespace Refactor\Console\Command;

use Refactor\Console\Output;
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
class Remover extends OutputCommand implements CommandInterface
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
     * @throws \Refactor\Exception\InvalidInputException
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters = null): void
    {
        $this->setOutput($output);

        if (!$this->applicationValidator->validate()) {
            $this->getOutput()->addFuckingLine(Output::TROLL_TO)->writeLines();

            return;
        }

        /** @var QuestionHelper $helper */
        $helper = $helperSet->get('question');
        $question = new ConfirmationQuestion('Are you sure you want to remove refactor-it from your project (y/N)?', false);

        if ($helper->ask($input, $output, $question)) {
            $this->getOutput()->addLine('Removing the refactor-it folder and files...', Output::FORMAT_INFO)->writeLines();

            if ($this->removeFilesAndDirectory($output) === true) {
                $this->getOutput()->addLine('The refactor-it folder and files are removed from the project!', Output::FORMAT_INFO)->writeLines();
            } else {
                $this->getOutput()
                    ->addLine('The refactor-it folder and files are removed from the project!', Output::FORMAT_INFO)
                    ->addFuckingLine(Output::TROLL_FROM_TO)
                    ->writeLines();
            }

            if ($this->cleanUpPrivateDirectory() === true) {
                $this->getOutput()
                    ->addLine('The private folder was empty so the folder is removed from your project!', Output::FORMAT_INFO)
                    ->addFuckingLine(Output::TROLL_FROM)
                    ->writeLines();
            } else {
                $this->getOutput()
                    ->addLine('Something went wrong while removing the private folder! Please try again...', Output::FORMAT_ERROR)
                    ->addFuckingLine(Output::TROLL_TO)
                    ->writeLines();
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
