<?php
namespace Refactor\Config;

use PHPUnit\Framework\TestCase;

/**
 * Class RulesTest
 * @package Refactor\Config
 */
class RulesTest extends TestCase
{
    /** @var Rules */
    private $rules;

    public function setUp()
    {
        parent::setUp();

        /** @var \Refactor\Config\Rules $rules */
        $this->rules = new \Refactor\Config\Rules();

        $this->rules->setOrderedClassElements([]);
        $this->rules->setArraySyntax(['syntax' => 'long']);
        $this->rules->setConcatSpace([]);
        $this->rules->setPhpdocTrim(false);
        $this->rules->setPhpdocOrder(true);
        $this->rules->setPhpdocScalar(true);
        $this->rules->setOrderedImports(true);
        $this->rules->setBlankLineBeforeReturn(false);
        $this->rules->setNoBlankLinesBeforeNamespace(false);
        $this->rules->setNoBlankLinesAfterPhpdoc(true);
        $this->rules->setNoEmptyPhpdoc(true);
        $this->rules->setNoEmptyStatement(true);
        $this->rules->setNoMixedEchoPrint(['use' => 'echo']);
        $this->rules->setNoTrailingWhitespace(false);
        $this->rules->setNoUnusedImports(true);
        $this->rules->setNoWhitespaceInBlankLine(true);
        $this->rules->setObjectOperatorWithoutWhitespace(true);
        $this->rules->setFunctionTypehintSpace(true);
        $this->rules->setNoExtraConsecutiveBlankLines(['token' => ['test']]);
        $this->rules->setPhpdocAddMissingParamAnnotation(false);
        $this->rules->setIsNull(true);
        $this->rules->setLinebreakAfterOpeningTag(false);
        $this->rules->setLowercaseCast(true);
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->rules);
    }

    public function testGettersAndSetters(): void
    {
        $this->assertTrue($this->rules->isPhpdocOrder());
        $this->assertTrue($this->rules->isPhpdocScalar());
        $this->assertTrue($this->rules->isOrderedImports());
        $this->assertTrue($this->rules->isNoBlankLinesAfterPhpdoc());
        $this->assertTrue($this->rules->isNoEmptyPhpdoc());
        $this->assertTrue($this->rules->isNoEmptyStatement());
        $this->assertTrue($this->rules->isNoUnusedImports());
        $this->assertTrue($this->rules->isNoWhitespaceInBlankLine());
        $this->assertTrue($this->rules->isObjectOperatorWithoutWhitespace());
        $this->assertTrue($this->rules->isFunctionTypehintSpace());
        $this->assertTrue($this->rules->isNull());
        $this->assertTrue($this->rules->isLowercaseCast());
        $this->assertEmpty($this->rules->getOrderedClassElements());
        $this->assertEmpty($this->rules->getConcatSpace());
        $this->assertFalse($this->rules->isPhpdocTrim());
        $this->assertFalse($this->rules->isBlankLineBeforeReturn());
        $this->assertFalse($this->rules->isNoBlankLinesBeforeNamespace());
        $this->assertFalse($this->rules->isNoTrailingWhitespace());
        $this->assertFalse($this->rules->isPhpdocAddMissingParamAnnotation());
        $this->assertFalse($this->rules->isLinebreakAfterOpeningTag());
        $this->assertIsArray($this->rules->getArraySyntax());
        $this->assertArrayHasKey('use', $this->rules->getNoMixedEchoPrint());
        $this->assertArrayHasKey('token', $this->rules->getNoExtraConsecutiveBlankLines());
    }

    public function testToArrayToWorksLikeExpected(): void
    {
        $this->assertIsArray($this->rules->toArray());
    }

    public function testFromJsonWorksLikeExpected(): void
    {
        $this->assertIsObject(
            $this->rules->fromJSON(
                $this->rules->toArray()
            )
        );
    }
}
