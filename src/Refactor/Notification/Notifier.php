<?php
namespace Refactor\Notification;

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;

/**
 * Class PushCommand
 * @package Refactor\Console
 */
class Notifier implements NotifierInterface
{
    /**
     * @param string $title
     * @param string $body
     * @param bool $exception
     */
    public function push(string $title, string $body, bool $exception): void
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
