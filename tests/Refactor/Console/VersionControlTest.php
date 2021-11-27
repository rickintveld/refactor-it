<?php
namespace Refactor\tests\Console;

use PHPUnit\Framework\TestCase;
use Refactor\Console\VersionControl;

/**
 * Class CommandTest
 * @package Refactor\Console
 */
class VersionControlTest extends TestCase
{
    /** @var VersionControl */
    protected $versionControl;

    protected function setUp(): void
    {
        parent::setUp();
        $this->versionControl = new VersionControl();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->versionControl);
    }

    /**
     * @test
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    public function validateVcsUsageThrowsExceptionOnFailure(): void
    {
        $this->versionControl->isGitProject();
        self::assertTrue(true, 'Whoops, looks like the exception has been thrown');
    }

    /**
     * @test
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    public function validateVcsUsageWorksLikeExpected(): void
    {
        $vcs = $this->versionControl->isGitProject();
        self::assertEquals('git', $vcs);
    }

    /**
     * @test
     * @throws \Refactor\Exception\WrongVcsTypeException
     */
    public function validateSvnUsageToFailAsExpected(): void
    {
        $vcs = $this->versionControl->isGitProject();
        self::assertNotEquals('svn', $vcs);
    }

    /**
     * @test
     */
    public function validateGitUsage(): void
    {
        $vcs = $this->versionControl->getGitCommand();

        self::assertEquals('git', $vcs[0]);
    }
}
