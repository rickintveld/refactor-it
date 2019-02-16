<?php
namespace Rocket\RefactorIt;

use Rocket\RefactorIt\Common\RefactorItCommand;
use Rocket\RefactorIt\Config\Config;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class Init
 * @package Rocket\RefactorIt
 */
class Init implements RefactorItCommand
{
    const REFACTOR_IT_PATH = '/private/refactor-it/';

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @param array $parameters
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters)
    {
        $resetProject = $parameters['reset-project'];

        if ($resetProject === false) {
            $config = $this->getProjectConfig(false);
            try {
                $this->writeConfig($config);
            } catch (\Exception $exception) {
                $output->writeln('<error>' . $exception->getMessage() . '</error>');
                return;
            }
        }

        if ($resetProject === true) {
            /** @var QuestionHelper $helper */
            $helper = $helperSet->get('question');
            $config = $this->getProjectConfig(true);

            $question = new ConfirmationQuestion('Are you sure you want to reset your project (y/N)?', false);

            if ($helper->ask($input, $output, $question)) {
                $output->writeln('Resetting the config');

                try {
                    $this->writeConfig($config);
                } catch (\Exception $exception) {
                    $output->writeln('<error>' . $exception->getMessage() . '</error>');
                    return;
                }
            }
        }

        $output->writeln('<info>Done writing the refactor-it config, it\'s located in the root of your project!</info>');
    }

    /**
     * @param bool $empty
     * @return Config
     */
    public function getProjectConfig($empty = false)
    {
        return $this->getConfig(new Config(), $empty);
    }

    /**
     * @param Config $config
     * @param bool $empty
     * @return Config
     */
    public function getConfig(Config $config, $empty = false)
    {
        if ($empty === false && file_exists($this->getRefactorItConfigFile())) {
            $json = file_get_contents($this->getRefactorItConfigFile());
            $config = $config->fromJSON(json_decode($json, true));
        }

        return $config;
    }

    /**
     * @param Config $config
     * @throws \Exception
     */
    public function writeConfig(Config $config)
    {
        $path = dirname($this->getRefactorItPath());

        if (file_exists($path) === false) {
            mkdir($path, 0777, true);
        }

        if (file_exists($this->getRefactorItPath()) === false) {
            mkdir($this->getRefactorItPath(), 0777, true);
        }

        if (@file_put_contents($this->getRefactorItConfigFile(), $config->toJSON()) === false) {
            throw new \Exception('Could not write config; either the directory doesn\'t exist or we have no permission to write (' . $path . ').');
        }
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
        return getcwd() . Init::REFACTOR_IT_PATH . Config::CONFIG_FILE;
    }
}