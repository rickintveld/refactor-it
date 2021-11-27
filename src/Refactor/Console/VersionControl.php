<?php
namespace Refactor\Console;

use Refactor\Console\Command\Finder;
use Refactor\Exception\WrongVcsTypeException;
use Symfony\Component\Process\Process;

class VersionControl
{
    public const GIT_COMMAND = ['git', 'diff', '--name-only', '--diff-filter=ACDMRTUXB', '--cached'];

    /**
     * @return array
     */
    public function getGitCommand(): array
    {
        return self::GIT_COMMAND;
    }

    /**
     * @throws WrongVcsTypeException
     * @return string
     */
    public function isGitProject(): string
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
        throw new WrongVcsTypeException(
            'There is no vcs config file found in the root of your project, the only supported vcs types are GIT and SVN!',
            1560678044538
        );
        // @codeCoverageIgnoreEnd
    }
}
