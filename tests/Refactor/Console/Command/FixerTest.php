<?php
namespace Refactor\tests\Console\Command;

use PHPUnit\Framework\TestCase;
use Refactor\Console\Command\Fixer;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class FixerTest extends TestCase
{
    private Fixer $fixer;

    public function setUp(): void
    {
        parent::setUp();
        $this->fixer = new Fixer();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->fixer);
    }

    /**
     * @throws \Refactor\Exception\FileNotFoundException
     * @throws \Refactor\Exception\UnknownVcsTypeException
     * @throws \Refactor\Exception\WrongVcsTypeException
     * @throws \Refactor\Exception\InvalidInputException
     */
    public function testFixerCommandWorksLikeExpected(): void
    {
        $input = new ArgvInput();
        $output = new ConsoleOutput();
        $this->fixer->execute($input, $output, new HelperSet(), []);

        self::assertNotEmpty($output->getErrorOutput(), 'The console output is not empty');
    }
}
