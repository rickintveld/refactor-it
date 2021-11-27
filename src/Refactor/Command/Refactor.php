<?php
namespace Refactor\Command;

use Refactor\Component\Serializer\JsonSerializer;
use Refactor\Config\Rules;
use Refactor\Exception\FileNotFoundException;
use Refactor\Utility\PathUtility;

class Refactor
{
    /**
     * @param string $file
     * @throws FileNotFoundException
     * @return array
     */
    public function execute(string $file): array
    {
        if (!file_exists($file)) {
            throw new FileNotFoundException(sprintf('The requested file %s could not be found!', $file), 1570183073903);
        }

        if (!file_exists($executable = PathUtility::getRootPath() . '/vendor/bin/php-cs-fixer')) {
            throw new FileNotFoundException('No php-cs-fixer executable found in the vendor bin folder', 1571751466166);
        }

        return [
            'php',
            $executable,
            'fix',
            $file,
            '--format=json',
            '--allow-risky=yes',
            '--using-cache=no',
            "--rules='{$this->inlineJsonConverter($this->configurationRules()->toJSON())}'"
        ];
    }

    /**
     * @throws FileNotFoundException
     * @return Rules
     */
    private function configurationRules(): Rules
    {
        if (!file_exists(PathUtility::getRefactorItRulesFile())) {
            // @codeCoverageIgnoreStart
            throw new FileNotFoundException(
                'The refactor rules file was not found! Try running refactor config in the root of your project',
                1560437366837
            );
            // @codeCoverageIgnoreEnd
        }

        $rules = new Rules();
        $json = file_get_contents(PathUtility::getRefactorItRulesFile());
        $rules->fromJSON($json);

        return $rules;
    }

    /**
     * @param string $rules
     * @return false|string
     */
    private function inlineJsonConverter(string $rules):? string
    {
        $serializer = new JsonSerializer();
        $inlineRules = $serializer->decode($rules);

        return $serializer->serialize($inlineRules);
    }
}
