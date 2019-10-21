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
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters = null): void
    {
        if (!$this->versionControlValidator->validate()) {
            throw new MissingVersionControlException('There was no version control system found in your project!', 1571643538278);
        }

        $removeHook = $parameters['remove-hook'];

        if ($removeHook === true) {
            try {
                $this->removePreCommitHook();
                $output->writeln('<info>Removing the GIT pre-commit file from the GIT hooks folder</info>');
            } catch (FileNotFoundException $exception) {
                $output->writeln('<error>' . $exception->getMessage() . '</error>');
            }
        }

        if ($removeHook === false) {
            try {
                $this->addPreCommitHook();
            } catch (FileNotFoundException $exception) {
                $output->writeln('<error>' . $exception->getMessage() . '</error>');
            }
        }
    }

    /**
     * @throws FileNotFoundException
     */
    private function addPreCommitHook(): void
    {
        $preCommitPlaceholder = dirname(__DIR__, 4) . '/hooks/' . self::PRE_COMMIT_FILE;
        $preCommitFile = PathUtility::getCommitHookPath() . '/' . self::PRE_COMMIT_FILE;

        if (!copy($preCommitPlaceholder, $preCommitFile)) {
            throw new FileNotFoundException('Something went wrong while copying the pre-commit hook file');
        }

        chmod($preCommitFile, 0755);
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
