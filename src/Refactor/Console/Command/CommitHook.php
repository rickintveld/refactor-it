<?php
namespace Refactor\Console\Command;

use Refactor\Exception\FileNotFoundException;
use Refactor\Exception\MissingVersionControlException;
use Refactor\Utility\PathUtility;
use Refactor\Validator\VersionControlValidator;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CommitHook
 * @package Refactor\Console\Command
 */
class CommitHook implements CommandInterface
{
    public const PRE_COMMIT_FILE = 'pre-commit';

    /** @var VersionControlValidator */
    private $versionControlValidator;

    /**
     * CommitHook constructor.
     */
    public function __construct()
    {
        $this->versionControlValidator = new VersionControlValidator();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @param array ...$parameters
     * @throws MissingVersionControlException
     * @throws FileNotFoundException
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters = null): void
    {
        if (!$this->versionControlValidator->validate()) {
            throw new MissingVersionControlException('There was no version control system found in your project!', 1571643538278);
        }

        if (isset($parameters['remove-hook']) && $parameters['remove-hook'] === true) {
            try {
                $this->removePreCommitHook();
                $output->writeln('Removing the GIT pre-commit file from the GIT hooks folder');
            } catch (FileNotFoundException $exception) {
                $output->writeln('<error>' . $exception->getMessage() . '</error>');
            }
        }

        try {
            $this->addPreCommitHook();
        } catch (FileNotFoundException $exception) {
            $output->writeln('<error>' . $exception->getMessage() . '</error>');
        }
    }

    /**
     * @throws FileNotFoundException
     */
    private function addPreCommitHook(): void
    {
        $preCommitFile = dirname(__DIR__, 4) . '/hooks/' . self::PRE_COMMIT_FILE;

        if (!copy($preCommitFile, PathUtility::getCommitHookPath() . '/' . self::PRE_COMMIT_FILE)) {
            throw new FileNotFoundException('Something went wrong while copying the pre-commit hook file');
        }
    }

    /**
     * @throws FileNotFoundException
     */
    private function removePreCommitHook(): void
    {
        if (!$this->versionControlValidator->preCommitHook()) {
            throw new FileNotFoundException('There was no pre-commit hook file found to remove');
        }

        unlink(PathUtility::getCommitHookPath() . '/' . self::PRE_COMMIT_FILE);
    }
}
