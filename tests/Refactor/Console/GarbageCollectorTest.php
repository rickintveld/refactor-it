<?php
namespace Refactor\Console;

use PHPUnit\Framework\TestCase;
use Refactor\Utility\PathUtility;

/**
 * Class GarbageCollectorTest
 * @package Refactor\Console
 */
class GarbageCollectorTest extends TestCase
{
    /** @var GarbageCollector */
    protected $garbageCollector;

    protected function setUp()
    {
        parent::setUp();
        $this->garbageCollector = new GarbageCollector();
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->garbageCollector);
    }

    public function testCleanUpCacheFileWorksAsExpected(): void
    {
        $cacheFile = PathUtility::getRootPath() . '/' . GarbageCollector::PHP_CS_CACHE_FILE;
        if (file_exists($cacheFile) === false) {
            $tempCacheFile = fopen($cacheFile, 'wb');
            fwrite($tempCacheFile, 'cleanUpCacheFileWorksAsExpected');
            fclose($tempCacheFile);
        }

        $this->garbageCollector->cleanUpCacheFile();
        $this->assertFileNotExists($cacheFile);
    }

    public function testCleanUpCacheFileExists(): void
    {
        $cacheFile = PathUtility::getRootPath() . '/' . GarbageCollector::PHP_CS_CACHE_FILE;
        if (file_exists($cacheFile) === false) {
            $tempCacheFile = fopen($cacheFile, 'wb');
            fwrite($tempCacheFile, 'cleanUpCacheFileWorksAsExpected');
            fclose($tempCacheFile);
        }

        $this->assertFileExists($cacheFile);
    }
}
