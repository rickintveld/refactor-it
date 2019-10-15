<?php
namespace Refactor\Console\Command;

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;
use Refactor\Common\NotifierInterface;

/**
 * Class PushCommand
 * @package Refactor\Console
 */
class NotifierCommand implements NotifierInterface
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
