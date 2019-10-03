<?php

namespace Refactor\Console;

use PHPUnit\Framework\TestCase;

/**
 * Class SignatureTest
 * @package Refactor\Console
 */
class SignatureTest extends TestCase
{
    /** @var string */
    private $signature;

    protected function setUp()
    {
        parent::setUp();
        $this->signature = Signature::write();
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->signature);
    }

    public function testSignatureOutputIsString(): void
    {
        $this->assertIsString($this->signature);
    }

    public function testSignatureOutputIsNotNull(): void
    {
        $this->assertNotNull($this->signature);
    }

    public function testSignatureOutputIsNotEmpty(): void
    {
        $this->assertNotEmpty($this->signature);
    }
}