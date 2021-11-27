<?php
namespace Refactor\tests\Log;

use PHPUnit\Framework\TestCase;
use Refactor\Cache\GarbageCollector;
use Refactor\Log\HistoryLogger;
use Refactor\Utility\PathUtility;

class HistoryLoggerTest extends TestCase
{
    private const LOG_MESSAGE = 'Refactor-it history command log message';

    private GarbageCollector $garbageCollector;
    private HistoryLogger $historyLogger;

    public function setUp(): void
    {
        parent::setUp();

        $this->garbageCollector = new GarbageCollector();
        $this->historyLogger = new HistoryLogger();
        $this->garbageCollector->removeHistory();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->garbageCollector->removeHistory();
        unset($this->garbageCollector);
    }

    /**
     * @throws \Exception
     */
    public function testAddLogMessage(): void
    {
        $this->historyLogger->log(self::LOG_MESSAGE);
        self::assertFileExists(PathUtility::getHistoryFile());

        $contents = explode("\n", @file_get_contents(PathUtility::getHistoryFile()));
        self::assertEquals(self::LOG_MESSAGE, $contents[0]);
    }
}
