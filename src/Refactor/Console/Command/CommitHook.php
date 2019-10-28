<?php
namespace Refactor\Console\Command;

use Refactor\App\Repository;
use Refactor\Console\Output;
use Refactor\Console\Signature;
use Refactor\Exception\FileNotFoundException;
use Refactor\Exception\MissingVersionControlException;
use Refactor\Troll\Fuck;
use Refactor\Utility\PathUtility;
use Refactor\Validator\VersionControlValidator;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CommitHook
 * @package Refactor\Console\Command
 */
class CommitHook extends OutputCommand implements CommandInterface
{
    public const PRE_COMMIT_FILE = 'pre-commit';

    /** @var Fuck */
    private $fuck;

    /** @var Repository */
    private $repository;

    /** @var VersionControlValidator */
    private $versionControlValidator;

    /**
     * CommitHook constructor.
     */
    public function __construct()
    {
        $this->fuck = new Fuck();
        $this->repository = new Repository();
        $this->versionControlValidator = new VersionControlValidator();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @param array ...$parameters
     * @throws MissingVersionControlException
     * @throws \Refactor\Exception\InvalidInputException
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters = null): void
    {
        $this->setOutput($output);

        if (!$this->versionControlValidator->validate()) {
            $this->getOutput()->addFuckingLine(Output::TROLL_TO)->writeLines();
            throw new MissingVersionControlException('There was no version control system found in your project!', 1571643538278);
        }

        $removeHook = $parameters['remove-hook'];

        if ($removeHook === true) {
            try {
                $this->removePreCommitHook();
                $this->getOutput()
                    ->addLine('Removing the GIT pre-commit file from the GIT hooks folder', Output::FORMAT_INFO)
                    ->addFuckingLine(Output::TROLL_FROM_TO)->writeLines();
            } catch (FileNotFoundException $exception) {
                $this->getOutput()
                    ->addLine($exception->getMessage(), Output::FORMAT_ERROR)
                    ->addFuckingLine(Output::TROLL_FROM_TO)->writeLines();
            }
        }

        if ($removeHook === false) {
            try {
                $this->addPreCommitHook();
                $this->getOutput()
                    ->addLine('The pre-commit hook has been added to the hooks folder', Output::FORMAT_INFO)->writeLines();
            } catch (FileNotFoundException $exception) {
                $this->getOutput()
                    ->addLine($exception->getMessage(), Output::FORMAT_ERROR)
                    ->addFuckingLine(Output::TROLL_FROM_TO)->writeLines();
            }
        }
    }

    /**
     * @throws FileNotFoundException
     * @throws \Refactor\Exception\InvalidInputException
     */
    private function addPreCommitHook(): void
    {
        $preCommitPlaceholder = dirname(__DIR__, 4) . '/hooks/' . self::PRE_COMMIT_FILE;
        $preCommitFile = PathUtility::getCommitHookPath() . '/' . self::PRE_COMMIT_FILE;

        if (!copy($preCommitPlaceholder, $preCommitFile)) {
            $this->getOutput()->addFuckingLine(Output::TROLL_TO)->writeLines();
            throw new FileNotFoundException('Something went wrong while copying the pre-commit hook file');
        }

        chmod($preCommitFile, 0755);
    }

    /**
     * @throws FileNotFoundException
     * @throws \Refactor\Exception\InvalidInputException
     */
    private function removePreCommitHook(): void
    {
        if (!$this->versionControlValidator->preCommitHook()) {
            $this->getOutput()->addFuckingLine(Output::TROLL_TO)->writeLines();
            throw new FileNotFoundException('There was no pre-commit hook file found to remove');
        }

        unlink(PathUtility::getCommitHookPath() . '/' . self::PRE_COMMIT_FILE);
    }
}
