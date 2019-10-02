<?php
namespace Refactor\Console;

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;
use Refactor\Common\NotifierInterface;

/**
 * Class GarbageCollector
 * @package Refactor\Console
 */
class GarbageCollector implements NotifierInterface
{
    public const PHP_CS_CACHE_FILE = '.php_cs.cache';

    public function cleanUpCacheFile(): void
    {
        if (file_exists(\Refactor\Utility\PathUtility::getRootPath() . '/' . self::PHP_CS_CACHE_FILE) === true) {
            unlink(\Refactor\Utility\PathUtility::getRootPath() . '/' . self::PHP_CS_CACHE_FILE);
            $this->pushNotification('Garbage notification', 'The garbage collector removed the php cache file!', false);
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
