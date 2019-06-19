<?php
namespace Refactor\Console;

use Symfony\Component\Process\Process;

/**
 * Class Finder
 * @package Refactor\Fixer
 */
class Finder
{
    private const GIT = 'git';
    private const GIT_CONFIG = '.git';
    private const SVN = 'svn';
    private const SVN_CONFIG = '.svn';

    /**
     * @param string $vcs
     * @throws \Refactor\Exception\UnknownVcsTypeException
     * @throws \Refactor\Exception\WrongVcsTypeException
     * @return array
     */
    public function findAdjustedFiles(): array
    {
        $vcs = $this->validateVcsUsage();

        $files = [];
        $process = new Process(
            $this->getVcsCommand($vcs)
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

    /**
     * @param string $vcs
     * @throws \Refactor\Exception\UnknownVcsTypeException
     * @return array
     */
    private function getVcsCommand(string $vcs): array
    {
        $commands = [];
        $vcs = strtolower($vcs);

        if (in_array($vcs, [self::GIT, self::SVN], true) === false) {
            throw new \Refactor\Exception\UnknownVcsTypeException(
                'The selected vcs type (' . $vcs . ') is not supported, only git and svn is supported!',
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
     * @throws \Refactor\Exception\WrongVcsTypeException
     * @return string
     */
    private function validateVcsUsage(): string
    {
        $files = [];
        $process = new Process(['ls', '-a']);
        $process->start();

        while ($process->isRunning()) {
            $files = explode("\n", $process->getOutput());
        }

        if (in_array(self::GIT_CONFIG, $files, true) === true) {
            return self::GIT;
        }
        if (in_array(self::SVN_CONFIG, $files, true) === true) {
            return self::SVN;
        }

        throw new \Refactor\Exception\WrongVcsTypeException(
            'There is no vcs config file found in the root of your project, the only supported vcs types are GIT and SVN!',
            1560678044538
        );
    }
}
