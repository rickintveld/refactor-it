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
    public function findAdjustedFilesWorksAsExpected(): void
    {
        $files = $this->finder->findAdjustedFiles();

        if (empty($files)) {
            $this->assertEmpty($files, 'No code changes where found!');
        } else {
            $this->assertIsArray($files, 'Some code changes where found!');
        }
    }
}
