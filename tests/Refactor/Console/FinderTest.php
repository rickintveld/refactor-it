<?php
namespace Refactor\Console;

use PHPUnit\Framework\TestCase;

/**
 * Class FinderTest
 * @package Refactor\Fixer
 */
class FinderTest extends TestCase
{
    /** @var Finder */
    protected $finder;

    protected function setUp()
    {
        parent::setUp();
        $this->finder = new Finder();
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->finder);
    }

    /**
     * @test
     * @throws \Refactor\Exception\UnknownVcsTypeException
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    public function findAdjustedFilesWorksAsExpected()
    {
        $files = $this->finder->findAdjustedFiles();
        $this->assertEmpty($files, 'No GIT diffs where found');
    }
}
