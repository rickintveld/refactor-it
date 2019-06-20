<?php
namespace Refactor\Console;

use Symfony\Component\Process\Process;

/**
 * Class Finder
 * @package Refactor\Fixer
 */
class Finder
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
     * @param string $vcs
     * @throws \Refactor\Exception\UnknownVcsTypeException
     * @throws \Refactor\Exception\WrongVcsTypeException
     * @return array
     */
    public function findAdjustedFiles(): array
    {
        $vcs = $this->command->validateVcsUsage();

        $files = [];
        $process = new Process(
            $this->command->getVcsCommand($vcs)
        );

        $process->start();
        while ($process->isRunning()) {
            $files = explode("\n", $process->getOutput());
        }

        return $this->getPhpFilesOnly($files, $vcs);
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
            if ($vcs === 'svn') {
                $file = substr($file, 1);
                $file = preg_replace('/\s+/', '', $file);
            }
            if (substr($file, -4) === '.php') {
                $filteredFiles[] = preg_replace('/\s+/', '\ ', getcwd() . '/' . $file);
            }
        }

        return $filteredFiles;
    }
}
