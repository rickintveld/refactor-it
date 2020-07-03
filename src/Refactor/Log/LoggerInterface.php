<?php
namespace Refactor\Log;

/**
 * Interface LoggerInterface
 * @package Refactor\Log
 */
interface LoggerInterface
{
    /**
     * Logs with an arbitrary level.
     *
     * @param string $message
     *
     * @return void
     */
    public function log(string $message): void;
}
