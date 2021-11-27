<?php
namespace Refactor\Log;

interface LoggerInterface
{
    /**
     * @param string $message
     * @return void
     */
    public function log(string $message): void;
}
