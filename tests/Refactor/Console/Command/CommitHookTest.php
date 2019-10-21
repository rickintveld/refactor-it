<?php
namespace Refactor\tests\Console\Command;

use PHPUnit\Framework\TestCase;
use Refactor\Console\Command\CommitHook;
use Refactor\Exception\MissingVersionControlException;
use Refactor\Validator\VersionControlValidator;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class CommitHookTest
 * @package Refactor\tests\Console\Command
 */
class CommitHookTest extends TestCase
{
    /** @var VersionControlValidator */
    private $versionControlValidator;

    public function setUp(): void
    {
        parent::setUp();
        $this->versionControlValidator = new VersionControlValidator();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->versionControlValidator);
    }

    /**
     * @throws MissingVersionControlException
     */
    public function testCopyPreCommitHookToGitHooksFolder(): void
    {
        $commitHook = new CommitHook();
        $input = new ArgvInput();
        $output = new ConsoleOutput();
        $commitHook->execute($input, $output, new HelperSet(), ['remove-hook' => false]);

        self::assertTrue($this->versionControlValidator->preCommitHook());
    }

    /**
     * @throws MissingVersionControlException
     */
    public function testRemovePreCommitHookFromGitHooksFolder(): void
    {
        $commitHook = new CommitHook();
        $input = new ArgvInput();
        $output = new ConsoleOutput();
        $commitHook->execute($input, $output, new HelperSet(), ['remove-hook' => true]);

        self::assertFalse($this->versionControlValidator->preCommitHook());
    }
}
