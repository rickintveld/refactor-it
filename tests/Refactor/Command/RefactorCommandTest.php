<?php
namespace Refactor\tests\Console\Command;

use PHPUnit\Framework\TestCase;
use Refactor\Command\Refactor;

class RefactorCommandTest extends TestCase
{
    private Refactor $refactorCommand;

    public function setUp(): void
    {
        parent::setUp();
        $this->refactorCommand = new Refactor();
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
        $this->refactorCommand->execute(dirname(__DIR__, 3) . '/exception.txt');
    }
}
