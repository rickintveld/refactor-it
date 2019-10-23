<?php
namespace Refactor\Console\Command;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use Refactor\Exception\FileNotFoundException;
use Refactor\Notification\Notifier;
use Refactor\Utility\PathUtility;
use Refactor\Validator\ApplicationValidator;
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
class Project extends Notifier implements CommandInterface
{
    /** @var ApplicationValidator */
    private $applicationValidator;

    /** @var Fixer */
    private $fixer;

    public function __construct()
    {
        $this->applicationValidator = new ApplicationValidator();
        $this->fixer = new Fixer();
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
            $output->writeln('<info>Refactoring all the php files within folder ' . $directory . '</info>');
            $files = $this->recursiveFileSearch($directory);

            if (empty($files)) {
                $output->writeln('<error>No files found to refactor, please try again or select another source folder...</error>');

                return;
            }

            try {
                $this->fixer->refactorAll($files);
            } catch (\Exception $exception) {
                $output->writeln('<error>' . $exception->getMessage() . '</error>');
            }
        }
    }

    /**
     * @param string $directory
     * @return array
     * @throws FileNotFoundException
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
