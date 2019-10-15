<?php
namespace Refactor\tests\Console\Command;

use PHPUnit\Framework\TestCase;
use Refactor\Console\Command\RefactorCommand;

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
        unset($this->refactorCommand);
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
