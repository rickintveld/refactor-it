<?php
namespace Refactor\Console;

use Symfony\Component\Process\Process;

/**
 * Class Finder
 * @package Refactor\Fixer
 */
class Finder
{
    private const VCS_SUPPORTED_TYPES = ['git', 'svn'];

    /**
     * @param string $vcs
     * @throws \Refactor\Exception\UnknownVcsTypeException
     * @throws \Refactor\Exception\WrongVcsTypeException
     * @return array
     */
    public function findAdjustedFiles(string $vcs): array
    {
        $this->validateSelectedVcsType($vcs);

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

        if (in_array($vcs, Finder::VCS_SUPPORTED_TYPES, true) === false) {
            throw new \Refactor\Exception\UnknownVcsTypeException(
                'The selected vcs type ('. $vcs .') is not supported, only git and svn is supported!',
                1560674657669
            );
        }
        if ($vcs === 'git') {
            $commands = ['git', 'diff', '--name-only', './'];
        }
        if ($vcs === 'svn') {
            $commands = ['svn', 'status'];
        }

        return $commands;
    }

    /**
     * @param string $vcs
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    private function validateSelectedVcsType(string $vcs)
    {
        $files = [];
        $vcsConfigFile = '.' . $vcs;
        $process = new Process(['ls', '-a']);
        $process->start();

        while ($process->isRunning()) {
            if ($process->isSuccessful()) {
                $files = explode("\n", $process->getOutput());
            }
        }

        if (in_array($vcsConfigFile, $files, true) === false) {
            throw new \Refactor\Exception\WrongVcsTypeException(
                'You have set the vcs config to ' . $vcs . ' but we found none or a another vcs config file in the root of your project. Try adjusting the config json settings and try again!',
                1560678044538
            );
        }
    }
}
