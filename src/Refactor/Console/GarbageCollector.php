<?php
namespace Refactor\Console;

use Refactor\Utility\PathUtility;

/**
 * Class GarbageCollector
 * @package Refactor\Console
 */
class GarbageCollector extends PushCommand
{
    public const PHP_CS_CACHE_FILE = '.php_cs.cache';

    public function cleanUpCacheFile(): void
    {
        if (file_exists(PathUtility::getRootPath() . '/' . self::PHP_CS_CACHE_FILE) === true) {
            unlink(PathUtility::getRootPath() . '/' . self::PHP_CS_CACHE_FILE);
            $this->pushNotification(
                'Garbage notification',
                'The garbage collector removed the php cache file!',
                false
            );
        }
    }

    /**
     * @param string $title
     * @param string $body
     * @param bool $exception
     */
    public function pushNotification(string $title, string $body, bool $exception): void
    {
        $notifier = NotifierFactory::create();
        $notification = new Notification();
        $notification
            ->setTitle($title)
            ->setBody($body)
            ->setIcon($exception ? NotifierInterface::SUCCESS_ICON : NotifierInterface::FAIL_ICON);

        $notifier->send($notification);
    }
}
