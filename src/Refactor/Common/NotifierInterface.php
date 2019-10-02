<?php

namespace Refactor\Common;

/**
 * Interface NotifierInterface
 * @package Refactor\Common
 */
interface NotifierInterface
{
    public const FAIL_ICON = '';
    public const SUCCESS_ICON = '';

    /**
     * @param string $title
     * @param string $body
     * @param bool $exception
     */
    public function pushNotification(string $title, string $body, bool $exception): void;
}