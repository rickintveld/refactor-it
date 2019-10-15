<?php
namespace Refactor\tests\Console\Command;

use PHPUnit\Framework\TestCase;
use Refactor\Init;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class InitTest
 * @package Refactor
 */
class InitCommandTest extends TestCase
{
    public function testExecuteCommand(): void
    {
        $init = new Init();
        $input = new ArgvInput();
        $output = new ConsoleOutput();
        $init->execute($input, $output, new HelperSet(), ['reset-rules' => false]);

        self::assertNotEmpty($output->getErrorOutput(), 'The console output is not empty');
    }
}
