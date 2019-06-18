<?php
namespace Refactor;

use Refactor\Common\RefactorCommandInterface;
use Refactor\Config\DefaultRules;
use Refactor\Console\Animal;
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
    const GITIGNORE_CONTENT = "/rules.json\r\n!/.gitignore";

    /** @var Animal */
    private $animal;

    public function __construct()
    {
        $this->animal = new Animal();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @param array $parameters
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters)
    {
        $resetConfig = $parameters['reset-config'];

        if ($resetConfig === false) {
            $rules = $this->getDefaultRules();
            try {
                $this->writeRefactorRules($rules);
                $this->configureGitIgnore();
            } catch (\Exception $exception) {
                $output->writeln('<error>' . $exception->getMessage() . '</error>');

                return;
            }
        }

        if ($resetConfig === true) {
            /** @var QuestionHelper $helper */
            $helper = $helperSet->get('question');
            $rules = $this->getDefaultRules(true);

            $question = new ConfirmationQuestion('Are you sure you want to reset your project (y/N)?', false);

            if ($helper->ask($input, $output, $question)) {
                $output->writeln('<info>Resetting the refactor-it config</info>');

                try {
                    $this->writeRefactorRules($rules);
                    $this->configureGitIgnore();
                } catch (\Exception $exception) {
                    $output->writeln('<error>' . $exception->getMessage() . '</error>');

                    return;
                }
            }
        }

        $output->writeln(
            '<info>' . $this->animal->speak('Done writing the refactor-it config. It\'s located in the root of your project in the private folder!') . '</info>'
        );
        $output->writeln('<info>' . \Refactor\Console\Signature::write() . '</info>');
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
        if ($empty === false && file_exists(PathUtility::getRefactorItRulesFile())) {
            $json = file_get_contents(PathUtility::getRefactorItRulesFile());
            $defaultRules = $defaultRules->fromJSON(json_decode($json, true));
        }

        return $defaultRules;
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
            throw new \Exception('Could not write the rules; either the directory doesn\'t exist or we have no permission to write (' . $path . ').', 1560888611458);
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
