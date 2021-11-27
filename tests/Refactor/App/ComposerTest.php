<?php
namespace Refactor\tests\App;

use PHPUnit\Framework\TestCase;
use Refactor\App\Composer;
use Refactor\Model\Author;

class ComposerTest extends TestCase
{
    private Composer $composer;

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

    public function testComposerPackageName(): void
    {
        self::assertEquals('rickintveld/refactor-it', $this->composer->getPackageName());
    }

    public function testAuthor(): void
    {
        $author = $this->composer->getAuthors()->first();

        self::assertInstanceOf(Author::class, $author);
        self::assertEquals('Rick in t Veld', $author->getName());
        self::assertEquals('rick.in.t.veld@opinity.nl', $author->getEmail());
    }

    public function testDescription(): void
    {
        self::assertEquals('Automated code refactor tool', $this->composer->getDescription());
    }

    public function testLicense(): void
    {
        self::assertEquals('MIT', $this->composer->getLicense());
    }

    public function testHomePage(): void
    {
        self::assertEquals('https://github.com/rickintveld/refactor-it/README.md', $this->composer->getHomepage());
    }
}
