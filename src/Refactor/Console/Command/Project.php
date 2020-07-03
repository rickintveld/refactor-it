<?php
namespace Refactor\Console\Command;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use Refactor\Console\Output;
use Refactor\Exception\FileNotFoundException;
use Refactor\Utility\PathUtility;
use RegexIterator;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Class Project
 * @package Refactor\Console\Refactor
 * @codeCoverageIgnore
 */
class Project extends OutputCommand implements CommandInterface
{
    /** @var Fixer */
    private $fixer;

    public function __construct()
    {
        parent::__construct();

        $this->fixer = new Fixer();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @param array ...$parameters
     * @throws FileNotFoundException
     * @throws \Refactor\Exception\InvalidInputException
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters = null): void
    {
        $this->setOutput($output);

        if (!$this->applicationValidator->validate()) {
            $this->getOutput()
                ->addFuckingLine(Output::TROLL_TO)->writeLines();

            return;
        }

        $files = array_diff(scandir(PathUtility::getRootPath()), ['.', '..']);

        /** @var QuestionHelper $helper */
        $helper = $helperSet->get('question');
        $question = new ChoiceQuestion(
            'Please select the source folder which you want to refactor...',
            array_values($files)
        );

        $question->setErrorMessage('Directory %s is invalid.');
        $question->setMaxAttempts(5);
        $question->setAutocompleterValues($files);

        if ($answer = $helper->ask($input, $output, $question)) {
            $directory = PathUtility::getRootPath() . '/' . $answer;

            $this->getOutput()->addLine('Refactoring all the php files within folder ' . $directory, Output::FORMAT_INFO)->writeLines();

            $files = $this->recursiveFileSearch($directory);
            if (empty($files)) {
                $this->getOutput()
                    ->addLine('No files found to refactor, please try again or select another source folder...', Output::FORMAT_ERROR)
                    ->addFuckingLine(Output::TROLL_FROM_TO, true)->writeLines();

                return;
            }

            try {
                $this->fixer->refactorAll($files);
            } catch (\Exception $exception) {
                $this->getOutput()
                    ->addLine($exception->getMessage(), Output::FORMAT_ERROR)
                    ->addFuckingLine(Output::TROLL_FROM)->writeLines();
            }
        }
    }

    /**
     * @param string $directory
     * @throws FileNotFoundException
     * @return array
     */
    private function recursiveFileSearch(string $directory): array
    {
        if (!is_dir($directory)) {
            return [];
        }

        $sourceFiles = [];
        $source = new RecursiveDirectoryIterator($directory);
        $iterator = new RecursiveIteratorIterator($source);
        $files = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

        $ignoreList = $this->getIgnoreContent();

        foreach ($files as $file) {
            if ($this->ignoreFile($file[0], $ignoreList)) {
                continue;
            }

            $sourceFiles[] = $file[0];
        }

        return $sourceFiles;
    }

    /**
     * @throws FileNotFoundException
     * @return array
     */
    private function getIgnoreContent(): array
    {
        if (!file_exists($gitIgnore = PathUtility::getRootPath() . '/.gitignore')) {
            throw new FileNotFoundException('No gitignore found in the root of your project.', 1571755999554);
        }

        return explode("\n", file_get_contents($gitIgnore));
    }

    /**
     * @param string $file
     * @param array $ignoreList
     * @return bool
     */
    private function ignoreFile(string $file, array $ignoreList): bool
    {
        foreach ($ignoreList as $ignored) {
            if (strpos($file, $ignored) !== false) {
                return true;
            }
        }

        return false;
    }
}
