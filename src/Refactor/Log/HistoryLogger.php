<?php
namespace Refactor\Log;

use Refactor\Utility\PathUtility;

class HistoryLogger implements LoggerInterface
{
    /**
     * @param string $message
     * @throws \Exception
     * @return void
     */
    public function log(string $message): void
    {
        $data = @file_get_contents(PathUtility::getHistoryFile());
        $data .= $message;
        @file_put_contents(PathUtility::getHistoryFile(), $data);
    }
}
