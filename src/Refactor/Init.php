<?php
namespace Refactor;

use Refactor\Config\Rules;
use Refactor\Console\Command\CommandInterface;
use Refactor\Console\Command\OutputCommand;
use Refactor\Console\Output;
use Refactor\Console\Signature;
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
class Init extends OutputCommand implements CommandInterface
{
    public const REFACTOR_IT_PATH = '/private/refactor-it/';
    public const GITIGNORE_CONTENT = "/rules.json\r\n!/.gitignore";

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param HelperSet $helperSet
     * @param array|null $parameters
     * @throws Exception\InvalidInputException
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output, HelperSet $helperSet, array $parameters = null): void
    {
        $this->setOutput($output);

        $resetRules = $parameters['reset-rules'];

        if ($resetRules === false) {
            $rules = $this->getRules();
            try {
                $this->writeRefactorRules($rules);
                $this->configureGitIgnore();
            } // @codeCoverageIgnoreStart
            catch (\Exception $exception) {
                $this->getOutput()
                    ->addLine($exception->getMessage(), Output::FORMAT_ERROR)
                    ->addFuckingLine(Output::TROLL_FROM_TO)
                    ->writeLines();

                return;
                // @codeCoverageIgnoreEnd
            }

            $this->getOutput()
                ->addLine('Done writing the refactor-it config. It\'s located in the root of your project in the private folder', Output::FORMAT_INFO)
                ->writeLines();
        }

        // @codeCoverageIgnoreStart
        if ($resetRules === true) {
            /** @var QuestionHelper $helper */
            $helper = $helperSet->get('question');
            $rules = $this->getRules(true);

            $question = new ConfirmationQuestion('Are you sure you want to reset your project (y/N)?', false);

            if ($helper->ask($input, $output, $question)) {
                $this->getOutput()
                    ->addLine('Resetting the refactor-it rules', Output::FORMAT_INFO)
                    ->writeLines();

                try {
                    $this->writeRefactorRules($rules);
                    $this->configureGitIgnore();
                } catch (\Exception $exception) {
                    $this->getOutput()
                        ->addLine($exception->getMessage(), Output::FORMAT_ERROR)
                        ->addFuckingLine(Output::TROLL_FROM_TO)
                        ->writeLines();

                    return;
                }

                $this->getOutput()->addLine('Done rewriting the refactor-it config.', Output::FORMAT_INFO);
            } else {
                $this->getOutput()->addFuckingLine(Output::TROLL_FROM_TO, true);
            }
        }

        $this->getOutput()
            ->addLine(Signature::write(), Output::FORMAT_INFO)
            ->writeLines();
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param bool $empty
     * @return Rules
     */
    private function getRules(bool $empty = false): Rules
    {
        return $this->getRefactorRules(new Rules(), $empty);
    }

    /**
     * @param Rules $rules
     * @param bool $empty
     * @return Rules
     */
    private function getRefactorRules(Rules $rules, bool $empty = false): Rules
    {
        if ($empty === false && file_exists(PathUtility::getRefactorItRulesFile())) {
            $json = file_get_contents(PathUtility::getRefactorItRulesFile());
            $rules = $rules->fromJSON(json_decode($json, true));
        }

        return $rules;
    }

    /**
     * @param Rules $rules
     * @throws \Exception
     */
    private function writeRefactorRules(Rules $rules): void
    {
        $path = dirname(PathUtility::getRefactorItPath());

        if (file_exists($path) === false) {
            // @codeCoverageIgnoreStart
            mkdir($path, 0777, true);
            // @codeCoverageIgnoreEnd
        }

        if (file_exists(PathUtility::getRefactorItPath()) === false) {
            // @codeCoverageIgnoreStart
            mkdir(PathUtility::getRefactorItPath(), 0777, true);
            // @codeCoverageIgnoreEnd
        }

        if (@file_put_contents(PathUtility::getRefactorItRulesFile(), $rules->toJSON()) === false) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Could not write the rules; either the directory doesn\'t exist or we have no permission to write (' . $path . ').', 1560888611458);
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * Generates the git ignore file!
     */
    private function configureGitIgnore(): void
    {
        $gitIgnore = PathUtility::getRefactorItPath() . '.gitignore';
        if (!file_exists($gitIgnore)) {
            // @codeCoverageIgnoreStart
            file_put_contents($gitIgnore, self::GITIGNORE_CONTENT);
            // @codeCoverageIgnoreEnd
        }
    }
}
