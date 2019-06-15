<?php
namespace Refactor\Console;

use Refactor\Config\Config;
use Refactor\Config\DefaultRules;
use Refactor\Utility\PathUtility;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Class Fixer
 * @package Refactor\Fixer
 */
class Fixer
{
    /** @var GarbageCollector */
    private $garbageCollector;

    /** @var Finder */
    private $finder;

    /**
     * Fixer constructor.
     */
    public function __construct()
    {
        $this->garbageCollector = new GarbageCollector();
        $this->finder = new Finder();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @throws \Refactor\Exception\FileNotFoundException
     * @throws \Refactor\Exception\UnknownVcsTypeException
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet)
    {
        try {
            $config = $this->getConfig();
        } catch (\Refactor\Exception\FileNotFoundException $exception) {
            throw $exception;
        }

        $this->runRefactor(
            $this->finder->findAdjustedFiles($config->getVcs()),
            $output
        );
    }

    /**
     * @param array $files
     * @param OutputInterface $output
     * @throws \Refactor\Exception\FileNotFoundException
     */
    private function runRefactor(array $files, OutputInterface $output)
    {
        foreach ($files as $file) {
            $process = Process::fromShellCommandline(implode(' ', $this->getRefactorCommand($file)));
            $process->run();

            if (!empty($process->getErrorOutput()) && strpos('.php_cs.cache', $process->getErrorOutput()) !== false) {
                $output->writeln('<error>😭' . $process->getErrorOutput() . '</error>');
            } else {
                $output->writeln('<info>😎 Done refactoring ' . $file . '</info>');
            }
        }

        $this->cleanUp($output);
        $this->signature($output);
    }

    /**
     * @param string $file
     * @throws \Refactor\Exception\FileNotFoundException
     * @return array
     */
    private function getRefactorCommand(string $file): array
    {
        return [
            'php',
            getcwd() . '/vendor/bin/php-cs-fixer',
            'fix',
            $file,
            '--format=json',
            '--allow-risky=yes',
            "--rules='{$this->getRules()->toJSON()}'"
        ];
    }

    /**
     * @throws \Refactor\Exception\FileNotFoundException
     * @return Config
     */
    private function getConfig(): Config
    {
        if (file_exists(PathUtility::getRefactorItConfigFile())) {
            $config = new Config();
            $json = file_get_contents(PathUtility::getRefactorItConfigFile());
            $config->fromJSON(json_decode($json, true));
        } else {
            throw new \Refactor\Exception\FileNotFoundException(
                'The config file was not found! Try running refactor config in the root of your project',
                1560437309238
            );
        }

        return $config;
    }

    /**
     * @throws \Refactor\Exception\FileNotFoundException
     * @return DefaultRules
     */
    private function getRules(): DefaultRules
    {
        if (file_exists(PathUtility::getRefactorItRulesFile())) {
            $rules = new DefaultRules();
            $json = file_get_contents(PathUtility::getRefactorItRulesFile());
            $rules->fromJSON(json_decode($json, true));
        } else {
            throw new \Refactor\Exception\FileNotFoundException(
                'The refactor rules file was not found! Try running refactor config in the root of your project',
                1560437366837
            );
        }

        return $rules;
    }

    /**
     * @param OutputInterface $output
     */
    private function cleanUp(OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln('<comment>Cleaning the cache...</comment>');
        $this->garbageCollector->cleanUp();
    }

    /**
     * @param OutputInterface $output
     */
    private function signature(OutputInterface $output)
    {
        $output->writeln('<info>' . Signature::write() . '</info>');
    }
}
