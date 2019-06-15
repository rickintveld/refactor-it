<?php
namespace Refactor\Console;

use Symfony\Component\Process\Process;

/**
 * Class Finder
 * @package Refactor\Fixer
 */
class Finder
{
    const VCS_TYPES = ['git', 'svn'];

    /**
     * @param string $vcs
     * @throws \Refactor\Exception\UnknownVcsTypeException
     * @return array
     */
    public function findAdjustedFiles(string $vcs): array
    {
        $files = [];
        $process = new Process(
            $this->getVcsCommand($vcs)
        );

        $process->start();
        while ($process->isRunning()) {
            if ($process->isSuccessful()) {
                $files = explode("\n", $process->getOutput());
            }
        }

        return $this->getPhpFilesOnly($files);
    }

    /**
     * @param array $files
     * @return array
     */
    private function getPhpFilesOnly(array $files): array
    {
        $filteredFiles = [];
        foreach ($files as $file) {
            if (substr($file, -4) === '.php') {
                $filteredFiles[] = getcwd() . '/' . $file;
            }
        }

        return $filteredFiles;
    }

    /**
     * @param string $vcs
     * @throws \Refactor\Exception\UnknownVcsTypeException
     * @return array
     */
    private function getVcsCommand(string $vcs): array
    {
        $commands = [];
        $vcs = strtolower($vcs);

        if (in_array($vcs, Finder::VCS_TYPES, true) === false) {
            throw new \Refactor\Exception\UnknownVcsTypeException(
                'The selected vcs type is not supported, only git and svn is supported!'
            );
        }

        if ($vcs === Finder::VCS_TYPES['git']) {
            $commands = ['git', 'diff', '--name-only', './'];
        }

        if ($vcs === Finder::VCS_TYPES['svn']) {
            $commands = ['svn', 'status'];
        }

        return $commands;
    }
}
