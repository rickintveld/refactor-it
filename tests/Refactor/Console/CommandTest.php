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
     * @throws \Refactor\Exception\UnknownVcsTypeException
     */
    public function getVcsCommandWorksAsExpected()
    {
        $command = $this->command->getVcsCommand('git');
        $this::assertNotEmpty($command, 'The commands array is not empty');
        $this::assertArrayNotHasKey('svn', $command);
    }

    /**
     * @test
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    public function validateVcsUsageThrowsExceptionOnFailure()
    {
        $this->command->validateVcsUsage();

        // Asserts to true if no exception is thrown
        $this->assertTrue(true);
    }
}