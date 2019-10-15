<?php
namespace Refactor\Validator;

use Refactor\Utility\PathUtility;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class ApplicationValidator
 * @package Refactor\Validator
 */
class ApplicationValidator implements ValidatorInterface
{
    /**
     * @return bool
     */
    public function validate(): bool
    {
        $output = new ConsoleOutput();

        if (file_exists(PathUtility::getRefactorItPath()) === false) {
            // @codeCoverageIgnoreStart
            $output->writeln('<info>The refactor-it folder was not found, stopping command...</info>');

            return false;
            // @codeCoverageIgnoreEnd
        }

        if (file_exists(PathUtility::getRefactorItRulesFile()) === false) {
            // @codeCoverageIgnoreStart
            $output->writeln('<info>The refactor-it rules file was not found, stopping command...</info>');

            return false;
            // @codeCoverageIgnoreEnd
        }

        return true;
    }
}
