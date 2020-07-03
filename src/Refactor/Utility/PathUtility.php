<?php
namespace Refactor\Utility;

use Refactor\Config\Rules;
use Refactor\Console\Command\Init;

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

    /**
     * @return string
     */
    public static function getGitIgnoreFile(): string
    {
        return self::getRefactorItPath() . '/.gitignore';
    }

    /**
     * @return string
     */
    public static function getHistoryFile(): string
    {
        return self::getRefactorItPath() . '/history.log';
    }

    /**
     * @return string
     */
    public static function getPrivatePath(): string
    {
        return self::getRootPath() . '/private';
    }

    /**
     * @return string
     */
    public static function getCommitHookPath(): string
    {
        return self::getRootPath() . '/.git/hooks';
    }
}
