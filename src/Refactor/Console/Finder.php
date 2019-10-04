<?php
namespace Refactor\Console;

use Refactor\Exception\UnknownVcsTypeException;
use Refactor\Exception\WrongVcsTypeException;
use Symfony\Component\Process\Process;

/**
 * Class Finder
 * @package Refactor\Fixer
 */
class Finder extends PushCommand
{
    public const GIT = 'git';
    public const GIT_CONFIG = '.git';
    public const SVN = 'svn';
    public const SVN_CONFIG = '.svn';

    /** @var Command */
    protected $command;

    /**
     * Finder constructor.
     */
    public function __construct()
    {
        $this->command = new Command();
    }

    /**
     * @throws UnknownVcsTypeException
     * @throws WrongVcsTypeException
     * @return array
     */
    public function findAdjustedFiles(): array
    {
        $commands = [];
        $count = 0;
        $files = [];
        $newFiles = [];
        $vcs = $this->command->validateVcsUsage();

        if (empty($vcs) === true) {
            // @codeCoverageIgnoreStart
            $this->pushNotification('Exception Error [1570009542585]', 'There is no version control system found in your project!', true);
            throw new UnknownVcsTypeException('There is no version control system found in your project!', 1570009542585);
            // @codeCoverageIgnoreEnd
        }

        if (in_array($vcs, Command::SVN_COMMAND, true)) {
            $commands = $this->command->getSvnCommand();
        }
        if (in_array($vcs, Command::GIT_COMMAND, true)) {
            $commands = $this->command->getGitCommands();
        }

        foreach ($commands as $command) {
            $process = new Process($command);
            $process->start();
            while ($process->isRunning()) {
                if ($count === 0) {
                    $files = explode(PHP_EOL, $process->getOutput());
                } else {
                    $newFiles = explode(PHP_EOL, $process->getOutput());
                }
            }
            $count++;
        }

        $allFiles = array_merge($files, $newFiles);

        return $this->getPhpFilesOnly(array_filter($allFiles), $vcs);
    }

    /**
     * @param array $files
     * @param string $vcs
     * @return array
     */
    private function getPhpFilesOnly(array $files, string $vcs): array
    {
        $filteredFiles = [];
        foreach ($files as $file) {
            if ($vcs === self::SVN) {
                // @codeCoverageIgnoreStart
                $file = substr($file, 1);
                $file = preg_replace('/\s+/', '', $file);
                // @codeCoverageIgnoreEnd
            }
            if (!empty($file) && substr($file, -4) === '.php') {
                $filteredFiles[] = preg_replace('/\s+/', '\ ', getcwd() . '/' . $file);
            }
        }

        return $filteredFiles;
    }
}
