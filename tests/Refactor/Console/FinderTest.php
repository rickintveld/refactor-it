<?php
namespace Refactor\tests\Console;

use PHPUnit\Framework\TestCase;
use Refactor\Console\Finder;

/**
 * Class FinderTest
 * @package Refactor\Fixer
 */
class FinderTest extends TestCase
{
    /** @var Finder */
    protected $finder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->finder = new Finder();
    }

    protected function tearDown(): void
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
            self::assertEmpty($files, 'No code changes where found!');
        } else {
            self::assertIsArray($files, 'Some code changes where found!');
        }
    }
}
