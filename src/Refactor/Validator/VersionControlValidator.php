<?php
namespace Refactor\Validator;

use Refactor\Console\Command\CommitHook;
use Refactor\Console\Command\Finder;
use Refactor\Utility\PathUtility;
use Symfony\Component\Process\Process;

/**
 * Class VersionControlValidator
 * @package Refactor\Validator
 */
class VersionControlValidator implements ValidatorInterface
{
    /**
     * @return bool
     */
    public function validate(): bool
    {
        $files = [];
        $process = new Process(['ls', '-a']);
        $process->start();

        while ($process->isRunning()) {
            $files = explode("\n", $process->getOutput());
        }

        return $this->fileExists($files, Finder::GIT_CONFIG);
    }

    /**
     * @return bool
     */
    public function preCommitHook(): bool
    {
        $files = scandir(PathUtility::getCommitHookPath());

        return $this->fileExists($files, CommitHook::PRE_COMMIT_FILE);
    }

    /**
     * @param array $files
     * @param string $configFile
     * @return bool
     */
    private function fileExists(array $files, string $configFile): bool
    {
        return in_array($configFile, $files, true);
    }
}
