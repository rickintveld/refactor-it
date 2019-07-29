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
        $this::assertArrayNotHasKey('svn', $command, 'Whoops SVN is found in the root of this project!');
    }

    /**
     * @test
     * @throws \Refactor\Exception\UnknownVcsTypeException
     * @expectedException \Refactor\Exception\UnknownVcsTypeException
     */
    public function getVcsCommandFailsAsExpected()
    {
        $vcs = 'fail';
        $this->command->getVcsCommand($vcs);
        $this->expectExceptionMessage('The selected vcs type (' . $vcs . ') is not supported, only git and svn is supported!');
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