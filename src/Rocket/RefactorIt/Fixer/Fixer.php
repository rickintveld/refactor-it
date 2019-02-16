<?php
namespace Rocket\RefactorIt\Fixer;

use Rocket\RefactorIt\Config\Config;
use Rocket\RefactorIt\Config\DefaultRules;
use Rocket\RefactorIt\Config\Rules;
use Rocket\RefactorIt\Init;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Fixer
 * @package Rocket\RefactorIt\Fixer
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
     * @param array $parameters
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters)
    {
        $refactorAll = $parameters['all'];

        $config = null;
        $rules = null;

        if ($refactorAll === false) {
            $finder = $this->finder->findAdjustedFiles($config, $rules);
        }

        if ($refactorAll === true) {

        }
    }

    /**
     * @return null|Config
     * @throws \Exception
     */
    private function getConfig():? Config
    {
        try {
            if (file_exists($this->getRefactorItConfigFile())) {
                $config = new Config();
                $json = file_get_contents($this->getRefactorItConfigFile());
                $config->fromJSON(json_decode($json, true));
            }
        } catch (\Exception $exception) {
            throw $exception;
        }

        return $config ?? null;
    }

    /**
     * @return null|DefaultRules
     * @throws \Exception
     */
    private function getRules()
    {
        try {
            if (file_exists($this->getRefactorItRulesFile())) {
                $rules = new DefaultRules();
                $json = file_get_contents($this->getRefactorItRulesFile());
                $rules->fromJSON(json_decode($json, true));
            }
        } catch (\Exception $exception) {
            throw $exception;
        }

        return $rules ?? null;
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