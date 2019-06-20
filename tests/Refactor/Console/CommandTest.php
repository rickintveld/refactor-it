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
        $this::assertNotEmpty($command);
        $this::assertIsArray($command);
        $this::assertArrayNotHasKey('svn', $command);
    }

    /**
     * @throws \Refactor\Exception\UnknownVcsTypeException
     */
    public function getVcsCommandThrowsException()
    {
        $this->command->getVcsCommand('test');
        $this->expectException(\Refactor\Exception\UnknownVcsTypeException::class);
        $this->expectExceptionMessage('The selected vcs type (test) is not supported, only git and svn is supported!');
    }

    /**
     * @test
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    public function validateVcsUsageWorksAsExpected()
    {
        $vcs = $this->command->validateVcsUsage();
        $this->assertEquals(Finder::GIT, $vcs);
    }
}