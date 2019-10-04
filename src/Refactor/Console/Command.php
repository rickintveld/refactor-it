<?php
namespace Refactor\Console;

use Refactor\Exception\WrongVcsTypeException;
use Symfony\Component\Process\Process;

/**
 * Class Command
 * @package Refactor\Console
 */
class Command extends PushCommand
{
    public const GIT_COMMAND = ['git', 'diff', '--name-only', './'];
    public const GIT_NEW_FILE_COMMAND = ['git', 'diff', '--name-only', '--diff-filter=A', '--cached'];
    public const SVN_COMMAND = ['svn', 'status'];

    /**
     * @return array
     */
    public function getGitCommands(): array
    {
        return [self::GIT_COMMAND, self::GIT_NEW_FILE_COMMAND];
    }

    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function getSvnCommand(): array
    {
        return [self::SVN_COMMAND];
    }

    /**
     * @throws WrongVcsTypeException
     * @return string
     */
    public function validateVcsUsage(): string
    {
        $files = [];
        $process = new Process(['ls', '-a']);
        $process->start();

        while ($process->isRunning()) {
            $files = explode("\n", $process->getOutput());
        }

        if (in_array(Finder::GIT_CONFIG, $files, true) === true) {
            return Finder::GIT;
        }
        // @codeCoverageIgnoreStart
        if (in_array(Finder::SVN_CONFIG, $files, true) === true) {
            return Finder::SVN;
        }

        $this->pushNotification(
            'Exception Error [1560678044538]',
            'There is no vcs config file found in the root of your project, the only supported vcs types are GIT and SVN!',
            true
        );

        throw new WrongVcsTypeException(
            'There is no vcs config file found in the root of your project, the only supported vcs types are GIT and SVN!',
            1560678044538
        );
        // @codeCoverageIgnoreEnd
    }
}
