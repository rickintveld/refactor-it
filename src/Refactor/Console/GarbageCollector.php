<?php
namespace Refactor\Console;

/**
 * Class GarbageCollector
 * @package Refactor\Console
 */
class GarbageCollector
{
    private const PHP_CS_CACHE_FILE = '.php_cs.cache';

    public function cleanUp()
    {
        if (file_exists(\Refactor\Utility\PathUtility::getRootPath() . '/' . self::PHP_CS_CACHE_FILE) === true) {
            unlink(\Refactor\Utility\PathUtility::getRootPath() . '/' . self::PHP_CS_CACHE_FILE);
        }
    }
}
