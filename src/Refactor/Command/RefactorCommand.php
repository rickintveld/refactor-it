<?php
namespace Refactor\Command;

use Refactor\Config\Rules;
use Refactor\Exception\FileNotFoundException;
use Refactor\Utility\PathUtility;

/**
 * Class RefactorCommand
 * @package Refactor\Command
 */
class RefactorCommand
{
    /**
     * @param string $file
     * @throws FileNotFoundException
     * @return array
     */
    public function getCommand(string $file): array
    {
        $binPath = dirname(__DIR__, 3) . '/vendor/bin';

        return [
            'php',
            $binPath . '/php-cs-fixer',
            'fix',
            $file,
            '--format=json',
            '--allow-risky=yes',
            '--using-cache=no',
            "--rules='{$this->getInlineRules($this->getRules()->toJSON())}'"
        ];
    }

    /**
     * @throws FileNotFoundException
     * @return Rules
     */
    private function getRules(): Rules
    {
        if (!file_exists(PathUtility::getRefactorItRulesFile())) {
            throw new FileNotFoundException(
                'The refactor rules file was not found! Try running refactor config in the root of your project',
                1560437366837
            );
        }

        $rules = new Rules();
        $json = file_get_contents(PathUtility::getRefactorItRulesFile());
        $rules->fromJSON(json_decode($json, true));

        return $rules;
    }

    /**
     * @param string $rules
     * @return false|string
     */
    private function getInlineRules(string $rules):? string
    {
        $inlineRules = json_decode($rules, true);

        return json_encode($inlineRules);
    }
}
