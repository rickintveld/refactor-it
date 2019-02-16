<?php
namespace Rocket\RefactorIt\Fixer;

use Rocket\RefactorIt\Config\Config;
use Rocket\RefactorIt\Config\DefaultRules;

/**
 * Class Finder
 * @package Rocket\RefactorIt\Fixer
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