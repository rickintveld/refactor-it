<?php
namespace Refactor\Console;

use PHPUnit\Framework\TestCase;

/**
 * Class SignatureTest
 * @package Refactor\Console
 */
class SignatureTest extends TestCase
{
    public function testSignatureOutputIsString(): void
    {
        $this->assertIsString(\Refactor\Console\Signature::write());
    }

    public function testSignatureOutputIsNotNull(): void
    {
        $this->assertNotNull(\Refactor\Console\Signature::write());
    }

    public function testSignatureOutputIsNotEmpty(): void
    {
        $this->assertNotEmpty(\Refactor\Console\Signature::write());
    }
}
