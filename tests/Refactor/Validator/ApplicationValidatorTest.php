<?php
namespace Refactor\tests\Validator;

use PHPUnit\Framework\TestCase;
use Refactor\Validator\ApplicationValidator;

/**
 * @codeCoverageIgnore
 */
class ApplicationValidatorTest extends TestCase
{
    private ApplicationValidator $applicationValidator;

    public function setUp(): void
    {
        parent::setUp();
        $this->applicationValidator = new ApplicationValidator();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->applicationValidator);
    }

    public function testApplicationIsPresent(): void
    {
        self::assertTrue($this->applicationValidator->validate());
    }
}
