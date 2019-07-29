<?php
namespace Refactor\Console;

use Symfony\Component\Process\Process;
use Refactor\Console\Finder;

/**
 * Class Command
 * @package Refactor\Console
 */
class Command
{
    public const GIT_COMMAND = ['git', 'diff', '--name-only', './'];
    public const SVN_COMMAND = ['svn', 'status'];

    /**
     * @param string $vcs
     * @throws \Refactor\Exception\UnknownVcsTypeException
     * @return array
     */
    public function getVcsCommand(string $vcs): array
    {
        $commands = [];
        $vcs = strtolower($vcs);

        if (in_array($vcs, [Finder::GIT, Finder::SVN], true) === false) {
            throw new \Refactor\Exception\UnknownVcsTypeException(
                'The selected vcs type (' . $vcs . ') is not supported, only git and svn is supported!',
                1560674657669
            );
        }
        if ($vcs === 'git') {
            $commands = self::GIT_COMMAND;
        }
        if ($vcs === 'svn') {
            $commands = self::SVN_COMMAND;
        }

        return $commands;
    }

    /**
     * @throws \Refactor\Exception\WrongVcsTypeException
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
        if (in_array(Finder::SVN_CONFIG, $files, true) === true) {
            return Finder::SVN;
        }

        throw new \Refactor\Exception\WrongVcsTypeException(
            'There is no vcs config file found in the root of your project, the only supported vcs types are GIT and SVN!',
            1560678044538
        );
    }
}