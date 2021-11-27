<?php
namespace Refactor\tests\Cache;

use PHPUnit\Framework\TestCase;
use Refactor\Cache\GarbageCollector;
use Refactor\Utility\PathUtility;

class GarbageCollectorTest extends TestCase
{
    protected GarbageCollector $garbageCollector;
    protected string $cacheFile;

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
        unset($this->garbageCollector, $this->cacheFile);
    }

    public function testCleanUpCacheFileExists(): void
    {
        self::assertFileExists($this->cacheFile);
    }

    public function testCleanUpCacheFileWorksAsExpected(): void
    {
        $this->garbageCollector->removeCache();
        self::assertFileNotExists($this->cacheFile);
    }
}
