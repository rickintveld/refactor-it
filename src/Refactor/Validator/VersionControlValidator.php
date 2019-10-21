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

        if (in_array(Finder::GIT_CONFIG, $files, true) === true) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function preCommitHook(): bool
    {
        $files = scandir(PathUtility::getCommitHookPath());
        if (in_array(CommitHook::PRE_COMMIT_FILE, $files, true)) {
            return true;
        }

        return false;
    }
}
