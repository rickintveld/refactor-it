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

    protected $cacheFile;

    protected function setUp()
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

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->garbageCollector);
    }

    public function testCleanUpCacheFileExists(): void
    {
        $this->assertFileExists($this->cacheFile);
    }

    public function testCleanUpCacheFileWorksAsExpected(): void
    {
        $this->garbageCollector->cleanUpCacheFile();
        $this->assertFileNotExists($this->cacheFile);
    }
}
