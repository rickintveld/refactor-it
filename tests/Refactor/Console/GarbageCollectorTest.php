<?php
namespace Refactor\Console;

use PHPUnit\Framework\TestCase;

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

    /**
     * @test
     */
    public function cleanUpCacheFileWorksAsExpected()
    {
        $cacheFile = \Refactor\Utility\PathUtility::getRootPath() . '/' . GarbageCollector::PHP_CS_CACHE_FILE;
        if (file_exists($cacheFile) === false) {
            $tempCacheFile = fopen($cacheFile, 'wb');
            fwrite($tempCacheFile, 'cleanUpCacheFileWorksAsExpected');
            fclose($tempCacheFile);
        }

        $this->garbageCollector->cleanUpCacheFile();
        $this->assertFileNotExists($cacheFile);
    }
}
