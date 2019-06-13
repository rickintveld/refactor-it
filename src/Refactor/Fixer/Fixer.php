<?php
namespace Refactor\Fixer;

use Refactor\Config\Config;
use Refactor\Config\DefaultRules;
use Refactor\Config\Rules;
use Refactor\Init;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Fixer
 * @package Refactor\Fixer
 */
class Fixer
{
    /** @var Finder */
    protected $finder;

    /**
     * Fixer constructor.
     */
    public function __construct()
    {
        $this->finder = new Finder();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @throws \Refactor\Exceptions\FileNotFoundException
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet)
    {
        try {
            $config = $this->getConfig();
            $rules = $this->getRules();
        } catch (\Refactor\Exceptions\FileNotFoundException $exception) {
            throw $exception;
        }

        $finder = $this->finder->findAdjustedFiles($config, $rules);
        /**
         * @todo fix the adjusted files!
         */
    }

    /**
     * @return Config
     * @throws \Refactor\Exceptions\FileNotFoundException
     */
    private function getConfig(): Config
    {
        if (file_exists($this->getRefactorItConfigFile())) {
            $config = new Config();
            $json = file_get_contents($this->getRefactorItConfigFile());
            $config->fromJSON(json_decode($json, true));
        } else {
            throw new \Refactor\Exceptions\FileNotFoundException('The config file was not found!', 1560437309238);
        }

        return $config;
    }

    /**
     * @return DefaultRules
     * @throws \Refactor\Exceptions\FileNotFoundException
     */
    private function getRules(): DefaultRules
    {
        if (file_exists($this->getRefactorItRulesFile())) {
            $rules = new DefaultRules();
            $json = file_get_contents($this->getRefactorItRulesFile());
            $rules->fromJSON(json_decode($json, true));
        } else {
            throw new \Refactor\Exceptions\FileNotFoundException('The refactor rules file was not found!', 1560437366837);
        }

        return $rules;
    }

    /**
     * @return string
     */
    private function getRefactorItPath(): string
    {
        return getcwd() . Init::REFACTOR_IT_PATH;
    }

    /**
     * @return string
     */
    private function getRefactorItConfigFile(): string
    {
        return $this->getRefactorItPath() . Config::CONFIG_FILE;
    }

    /**
     * @return string
     */
    private function getRefactorItRulesFile(): string
    {
        return $this->getRefactorItPath() . DefaultRules::RULES_FILE;
    }
}