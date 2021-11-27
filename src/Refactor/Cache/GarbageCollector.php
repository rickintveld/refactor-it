<?php
namespace Refactor\Cache;

use Refactor\Utility\PathUtility;

class GarbageCollector
{
    public const PHP_CS_CACHE_FILE = '.php_cs.cache';

    public function removeCache(): void
    {
        if (file_exists(PathUtility::getRootPath() . '/' . self::PHP_CS_CACHE_FILE) === true) {
            unlink(PathUtility::getRootPath() . '/' . self::PHP_CS_CACHE_FILE);
        }
    }

    public function removeHistory(): void
    {
        if (file_exists(PathUtility::getHistoryFile()) === true) {
            unlink(PathUtility::getHistoryFile());
        }
    }
}
