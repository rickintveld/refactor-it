<?php
namespace Refactor\Cache;

use Refactor\Notification\Notifier;
use Refactor\Utility\PathUtility;

/**
 * Class GarbageCollector
 * @package Refactor\Console
 */
class GarbageCollector extends Notifier
{
    public const PHP_CS_CACHE_FILE = '.php_cs.cache';

    public function removeCache(): void
    {
        if (file_exists(PathUtility::getRootPath() . '/' . self::PHP_CS_CACHE_FILE) === true) {
            unlink(PathUtility::getRootPath() . '/' . self::PHP_CS_CACHE_FILE);
            $this->push(
                'Garbage notification',
                'The garbage collector removed the php cache file!',
                false
            );
        }
    }
}
