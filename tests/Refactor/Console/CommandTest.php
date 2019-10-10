<?php
namespace Refactor\Console;

use PHPUnit\Framework\TestCase;

/**
 * Class CommandTest
 * @package Refactor\Console
 */
class CommandTest extends TestCase
{
    /** @var Command */
    protected $command;

    protected function setUp(): void
    {
        parent::setUp();
        $this->command = new Command();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->command);
    }

    /**
     * @test
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    public function validateVcsUsageThrowsExceptionOnFailure(): void
    {
        $this->command->validateVcsUsage();
        self::assertTrue(true, 'Whoops, looks like the exception has been thrown');
    }

    /**
     * @test
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    public function validateVcsUsageWorksLikeExpected(): void
    {
        $vcs = $this->command->validateVcsUsage();
        self::assertEquals('git', $vcs);
    }

    /**
     * @test
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    public function validateSvnUsageToFailAsExpected(): void
    {
        $vcs = $this->command->validateVcsUsage();
        self::assertNotEquals('svn', $vcs);
    }

    /**
     * @test
     */
    public function validateGitUsage(): void
    {
        $vcs = $this->command->getGitCommands();

        $git = $vcs[0];
        self::assertEquals('git', $git[0]);
    }
}
