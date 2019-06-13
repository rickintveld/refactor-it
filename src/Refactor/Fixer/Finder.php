<?php
namespace Refactor\Fixer;

use Refactor\Config\Config;
use Refactor\Config\DefaultRules;

/**
 * Class Finder
 * @package Refactor\Fixer
 */
class Finder
{
    /**
     * @param Config $config
     * @param DefaultRules $defaultRules
     * @return \PhpCsFixer\Config|\PhpCsFixer\ConfigInterface
     */
    public function findAdjustedFiles(Config $config, DefaultRules $defaultRules)
    {
        $finder = \PhpCsFixer\Finder::create()->in($config->getProjectPath());

        return \PhpCsFixer\Config::create()
            ->setRules($defaultRules->toArray())
            ->setIndent($config->getIndenting())
            ->setLineEnding($config->getLineEnding())
            ->setFormat($config->getFormat())
            ->setFinder($finder);
    }

}