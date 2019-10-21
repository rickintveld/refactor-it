<?php
namespace Refactor\tests\App;

use PHPUnit\Framework\TestCase;
use Refactor\App\Composer;

/**
 * Class ComposerTest
 * @package Refactor\tests\App
 */
class ComposerTest extends TestCase
{
    /** @var Composer */
    private $composer;

    public function setUp(): void
    {
        parent::setUp();
        $this->composer = new Composer();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->composer);
    }

    public function testComposerVersion(): void
    {
        $version = $this->composer->getVersion();
        self::assertIsString($version);
    }
}
