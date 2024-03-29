<?php
namespace Refactor\tests\Console\Command;

use PHPUnit\Framework\TestCase;
use Refactor\Console\Command\Finder;

class FinderTest extends TestCase
{
    protected Finder $finder;

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
        $files = $this->finder->getChangedFiles();

        if (empty($files)) {
            self::assertEmpty($files, 'No code changes where found!');
        } else {
            self::assertIsArray($files, 'Some code changes where found!');
        }
    }
}
