<?php
namespace Refactor\Utility;

use Refactor\Config\Rules;
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
    public static function getRefactorItRulesFile(): string
    {
        return self::getRefactorItPath() . Rules::RULES_FILE;
    }
}
