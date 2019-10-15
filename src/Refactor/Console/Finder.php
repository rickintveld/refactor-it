<?php
namespace Refactor\Console;

use Refactor\Console\Command\NotifierCommand;
use Refactor\Exception\UnknownVcsTypeException;
use Refactor\Exception\WrongVcsTypeException;
use Symfony\Component\Process\Process;

/**
 * Class Finder
 * @package Refactor\Fixer
 */
class Finder extends NotifierCommand
{
    public const GIT = 'git';
    public const GIT_CONFIG = '.git';
    public const SVN = 'svn';
    public const SVN_CONFIG = '.svn';

    /** @var VersionControl */
    protected $versionControl;

    /**
     * Finder constructor.
     */
    public function __construct()
    {
        $this->versionControl = new VersionControl();
    }

    /**
     * @throws UnknownVcsTypeException
     * @throws WrongVcsTypeException
     * @return array
     */
    public function findAdjustedFiles(): array
    {
        $command = [];
        $count = 0;
        $files = [];
        $newFiles = [];
        $vcs = $this->versionControl->validateVcsUsage();

        if (empty($vcs)) {
            // @codeCoverageIgnoreStart
            $this->push('Exception Error [1570009542585]', 'There is no version control system found in your project!', true);
            throw new UnknownVcsTypeException('There is no version control system found in your project!', 1570009542585);
            // @codeCoverageIgnoreEnd
        }

        if (in_array($vcs, VersionControl::SVN_COMMAND, true)) {
            // @codeCoverageIgnoreStart
            $command = $this->versionControl->getSvnCommand();
            // @codeCoverageIgnoreEnd
        }
        if (in_array($vcs, VersionControl::GIT_COMMAND, true)) {
            $command = $this->versionControl->getGitCommand();
        }

        if (empty($command)) {
            // @codeCoverageIgnoreStart
            $this->push('Exception Error [1570803899092]', 'There is no command found for the used vcs type!', true);
            throw new UnknownVcsTypeException('There is no command found for the used vcs type!', 1570803899092);
            // @codeCoverageIgnoreEnd
        }

        $process = new Process($command);
        $process->start();
        while ($process->isRunning()) {
            if ($count === 0) {
                $files = explode(PHP_EOL, $process->getOutput());
            } else {
                $newFiles = explode(PHP_EOL, $process->getOutput());
            }
        }

        $allFiles = array_merge($files, $newFiles);

        return $this->getPhpFilesOnly(array_unique(array_filter($allFiles)), $vcs);
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
