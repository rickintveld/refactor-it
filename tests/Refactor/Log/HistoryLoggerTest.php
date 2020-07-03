<?php
namespace Refactor\tests\Log;

use PHPUnit\Framework\TestCase;
use Refactor\Cache\GarbageCollector;
use Refactor\Log\HistoryLogger;
use Refactor\Utility\PathUtility;

/**
 * Class HistoryLoggerTest
 * @package Refactor\tests\Log
 */
class HistoryLoggerTest extends TestCase
{
    private const LOG_MESSAGE = 'Refactor-it history command log message';

    /** @var \Refactor\Cache\GarbageCollector */
    private $garbageCollector;

    /** @var \Refactor\Log\HistoryLogger */
    private $historyLogger;

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
        $this->assertFileExists(PathUtility::getHistoryFile());
    }

    public function testLogMessage(): void
    {
        $this->historyLogger->log(self::LOG_MESSAGE);
        $contents = explode("\n", @file_get_contents(PathUtility::getHistoryFile()));
        $this->assertEquals($contents[0], self::LOG_MESSAGE);
    }
}
