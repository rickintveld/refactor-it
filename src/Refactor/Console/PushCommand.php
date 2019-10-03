<?php
namespace Refactor\Console;

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;
use Refactor\Common\NotifierInterface;

/**
 * Class PushCommand
 * @package Refactor\Console
 */
class PushCommand implements NotifierInterface
{

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
