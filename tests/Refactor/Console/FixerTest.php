<?php
namespace Refactor\Console;

use PHPUnit\Framework\TestCase;

/**
 * Class FinderTest
 * @package Refactor\Fixer
 */
class FixerTest extends TestCase
{
    /** @var Fixer */
    protected $fixer;

    protected function setUp()
    {
        parent::setUp();
        $this->fixer = new Fixer();
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->fixer);
    }

}
