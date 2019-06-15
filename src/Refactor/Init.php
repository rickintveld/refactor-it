<?php
namespace Refactor;

use Refactor\Common\RefactorCommandInterface;
use Refactor\Config\Config;
use Refactor\Config\DefaultRules;
use Refactor\Utility\PathUtility;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class Init
 * @package Refactor
 */
class Init implements RefactorCommandInterface
{
    const REFACTOR_IT_PATH = '/private/refactor-it/';
    const GITIGNORE_CONTENT = "/*\r\n!/config.json\r\n/rules.json\r\n!/.gitignore";

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
            $config = $this->getProjectConfig();
            $rules = $this->getDefaultRules();
            try {
                $this->writeConfig($config);
                $this->writeRefactorRules($rules);
                $this->configureGitIgnore();
            } catch (\Exception $exception) {
                $output->writeln('<error>' . $exception->getMessage() . '</error>');

                return;
            }
        }

        if ($resetProject === true) {
            /** @var QuestionHelper $helper */
            $helper = $helperSet->get('question');
            $config = $this->getProjectConfig(true);
            $rules = $this->getDefaultRules(true);

            $question = new ConfirmationQuestion('Are you sure you want to reset your project (y/N)?', false);

            if ($helper->ask($input, $output, $question)) {
                $output->writeln('<info>Resetting the refactor-it config</info>');

                try {
                    $this->writeConfig($config);
                    $this->writeRefactorRules($rules);
                    $this->configureGitIgnore();
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
    private function getProjectConfig(bool $empty = false)
    {
        return $this->getConfig(new Config(), $empty);
    }

    /**
     * @param Config $config
     * @param bool $empty
     * @return Config
     */
    private function getConfig(Config $config, bool $empty = false)
    {
        if ($empty === false && file_exists($this->getRefactorItConfigFile())) {
            $json = file_get_contents($this->getRefactorItConfigFile());
            $config = $config->fromJSON(json_decode($json, true));
        }

        return $config;
    }

    /**
     * @param bool $empty
     * @return DefaultRules
     */
    private function getDefaultRules(bool $empty = false): DefaultRules
    {
        return $this->getRefactorRules(new DefaultRules(), $empty);
    }

    /**
     * @param DefaultRules $defaultRules
     * @param bool $empty
     * @return DefaultRules
     */
    private function getRefactorRules(DefaultRules $defaultRules, bool $empty = false): DefaultRules
    {
        if ($empty === false && file_exists($this->getRefactorItRulesFile())) {
            $json = file_get_contents($this->getRefactorItRulesFile());
            $defaultRules = $defaultRules->fromJSON(json_decode($json, true));
        }

        return $defaultRules;
    }

    /**
     * @param Config $config
     * @throws \Exception
     */
    private function writeConfig(Config $config)
    {
        $path = dirname(PathUtility::getRefactorItPath());

        if (file_exists($path) === false) {
            mkdir($path, 0777, true);
        }

        if (file_exists(PathUtility::getRefactorItPath()) === false) {
            mkdir(PathUtility::getRefactorItPath(), 0777, true);
        }

        if (@file_put_contents(PathUtility::getRefactorItConfigFile(), $config->toJSON()) === false) {
            throw new \Exception('Could not write config; either the directory doesn\'t exist or we have no permission to write (' . $path . ').');
        }
    }

    /**
     * @param DefaultRules $defaultRules
     * @throws \Exception
     */
    private function writeRefactorRules(DefaultRules $defaultRules)
    {
        $path = dirname(PathUtility::getRefactorItPath());

        if (file_exists($path) === false) {
            mkdir($path, 0777, true);
        }

        if (file_exists(PathUtility::getRefactorItPath()) === false) {
            mkdir(PathUtility::getRefactorItPath(), 0777, true);
        }

        if (@file_put_contents(PathUtility::getRefactorItRulesFile(), $defaultRules->toJSON()) === false) {
            throw new \Exception('Could not write the rules; either the directory doesn\'t exist or we have no permission to write (' . $path . ').');
        }
    }

    /**
     * Generates the git ignore file!
     */
    private function configureGitIgnore()
    {
        $gitIgnore = PathUtility::getRefactorItPath() . '.gitignore';
        if (!file_exists($gitIgnore)) {
            file_put_contents($gitIgnore, self::GITIGNORE_CONTENT);
        }
    }
}
