<?php

namespace Refactor\Console;

use PHPUnit\Framework\TestCase;

/**
 * Class AnimalTest
 * @package Refactor\Console
 */
class AnimalTest extends TestCase
{
    /** @var Animal */
    private $animal;

    protected function setUp()
    {
        parent::setUp();
        $this->animal = new Animal();
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->animal);
    }

    /**
     * @test
     */
    public function validateAnimalSpeakOutputIsStringAndNotEmpty(): void
    {
        $speak = $this->animal->speak('Text to speak');
        $this->assertNotEmpty($speak);
        $this->assertNotNull($speak);
        $this->assertIsString($speak);
    }
}