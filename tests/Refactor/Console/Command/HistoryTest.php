<?php
namespace Refactor\tests\Console\Command;

use PHPUnit\Framework\TestCase;
use Refactor\Console\Command\History;
use Refactor\Utility\PathUtility;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class InitTest
 * @package Refactor
 */
class HistoryTest extends TestCase
{
    /**
     * @throws \Refactor\Exception\InvalidInputException
     */
    public function testExecuteCommandWithClearArgument(): void
    {
        $history = new History();
        $input = new ArgvInput();
        $output = new ConsoleOutput();
        $history->execute($input, $output, new HelperSet(), ['clear' => true]);

        $this->assertFileNotExists(PathUtility::getHistoryFile());
    }
}
