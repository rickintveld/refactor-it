<?php
namespace Refactor\Utility;

use Refactor\Config\Config;
use Refactor\Config\DefaultRules;
use Refactor\Init;

/**
 * Class PathUtility
 * @package Refactor\Utility
 */
class PathUtility
{
    /**
     * @return string
     */
    public static function getRootPath(): string
    {
        return getcwd();
    }

    /**
     * @return string
     */
    public static function getRefactorItPath(): string
    {
        return self::getRootPath() . Init::REFACTOR_IT_PATH;
    }

    /**
     * @return string
     */
    public static function getRefactorItConfigFile(): string
    {
        return self::getRefactorItPath() . Config::CONFIG_FILE;
    }

    /**
     * @return string
     */
    public static function getRefactorItRulesFile(): string
    {
        return self::getRefactorItPath() . DefaultRules::RULES_FILE;
    }
}
