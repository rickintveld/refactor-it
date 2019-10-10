<?php
namespace Refactor\Command;

use PHPUnit\Framework\TestCase;

/**
 * Class RefactorCommandTest
 * @package Refactor\Command
 */
class RefactorCommandTest extends TestCase
{
    /** @var RefactorCommand */
    private $refactorCommand;

    public function setUp(): void
    {
        parent::setUp();
        $this->refactorCommand = new RefactorCommand();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @throws \Refactor\Exception\FileNotFoundException
     * @expectedException \Refactor\Exception\FileNotFoundException
     */
    public function testRefactorCommandToFailAsExpected(): void
    {
        $this->refactorCommand->getCommand(dirname(__DIR__, 3) . '/exception.txt');
    }
}
