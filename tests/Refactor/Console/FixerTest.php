<?php
namespace Refactor\Console;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class FixerTest
 * @package Refactor\Console
 */
class FixerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @throws \Refactor\Exception\FileNotFoundException
     * @throws \Refactor\Exception\UnknownVcsTypeException
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    public function testFixerCommandWorksLikeExpected(): void
    {
        $fixer = new Fixer();
        $input = new ArgvInput();
        $output = new ConsoleOutput();
        $fixer->execute($input, $output, new HelperSet(), []);

        self::assertNotEmpty($output->getErrorOutput(), 'The console output is not empty');
    }
}
