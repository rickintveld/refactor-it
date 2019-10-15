<?php
namespace Refactor\tests\Console;

use PHPUnit\Framework\TestCase;
use Refactor\Console\GarbageCollector;
use Refactor\Utility\PathUtility;

/**
 * Class GarbageCollectorTest
 * @package Refactor\Console
 */
class GarbageCollectorTest extends TestCase
{
    /** @var GarbageCollector */
    protected $garbageCollector;

    protected $cacheFile;

    protected function setUp(): void
    {
        parent::setUp();
        $this->garbageCollector = new GarbageCollector();

        $this->cacheFile = PathUtility::getRootPath() . '/' . GarbageCollector::PHP_CS_CACHE_FILE;
        if (file_exists($this->cacheFile) === false) {
            $tempCacheFile = fopen($this->cacheFile, 'wb');
            fwrite($tempCacheFile, 'cleanUpCacheFileWorksAsExpected');
            fclose($tempCacheFile);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->garbageCollector);
    }

    public function testCleanUpCacheFileExists(): void
    {
        self::assertFileExists($this->cacheFile);
    }

    public function testCleanUpCacheFileWorksAsExpected(): void
    {
        $this->garbageCollector->cleanUpCacheFile();
        self::assertFileNotExists($this->cacheFile);
    }
}
