<?php
namespace Refactor;

use PHPUnit\Framework\TestCase;

/**
 * Class InitTest
 * @package Refactor
 */
class InitTest extends TestCase
{
    /** @var Init */
    private $init;

    public function setUp()
    {
        parent::setUp();
        $this->init = new Init();
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->init);
    }
}