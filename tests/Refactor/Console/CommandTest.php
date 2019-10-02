<?php
namespace Refactor\Console;

/**
 * Class CommandTest
 * @package Refactor\Console
 */
class CommandTest extends \PHPUnit\Framework\TestCase
{
    /** @var Command */
    protected $command;

    protected function setUp()
    {
        parent::setUp();
        $this->command = new Command();
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->command);
    }

    /**
     * @test
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    public function validateVcsUsageThrowsExceptionOnFailure()
    {
        $this->command->validateVcsUsage();
        $this->assertTrue(true, 'Whoops, looks like the exception has been thrown');
    }

    /**
     * @test
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    public function validateVcsUsageWorksLikeExpected()
    {
        $vcs = $this->command->validateVcsUsage();
        $this->assertEquals('git', $vcs);
    }
}