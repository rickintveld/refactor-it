<?php
namespace Refactor\Config;

use PHPUnit\Framework\TestCase;

/**
 * Class RulesTest
 * @package Refactor\Config
 */
class RulesTest extends TestCase
{
    /** @var \Refactor\Config\Rules */
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
        $this->rules->setPhpdocTypes(true);
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

    public function testObjectGetters(): void
    {
        self::assertTrue($this->rules->isPhpdocTypes());
        self::assertTrue($this->rules->isPhpdocOrder());
        self::assertTrue($this->rules->isPhpdocScalar());
        self::assertTrue($this->rules->isOrderedImports());
        self::assertTrue($this->rules->isNoBlankLinesAfterPhpdoc());
        self::assertTrue($this->rules->isNoEmptyPhpdoc());
        self::assertTrue($this->rules->isNoEmptyStatement());
        self::assertTrue($this->rules->isNoUnusedImports());
        self::assertTrue($this->rules->isNoWhitespaceInBlankLine());
        self::assertTrue($this->rules->isObjectOperatorWithoutWhitespace());
        self::assertTrue($this->rules->isFunctionTypehintSpace());
        self::assertTrue($this->rules->isNull());
        self::assertTrue($this->rules->isLowercaseCast());
        self::assertEmpty($this->rules->getOrderedClassElements());
        self::assertEmpty($this->rules->getConcatSpace());
        self::assertFalse($this->rules->isPhpdocTrim());
        self::assertFalse($this->rules->isBlankLineBeforeReturn());
        self::assertFalse($this->rules->isNoBlankLinesBeforeNamespace());
        self::assertFalse($this->rules->isNoTrailingWhitespace());
        self::assertFalse($this->rules->isPhpdocAddMissingParamAnnotation());
        self::assertFalse($this->rules->isLinebreakAfterOpeningTag());
        self::assertIsArray(['syntax' => 'long', 'array' => 'short']);
        self::assertArrayHasKey('use', $this->rules->getNoMixedEchoPrint());
        self::assertArrayHasKey('token', $this->rules->getNoExtraConsecutiveBlankLines());
    }

    public function testToArrayToWorksLikeExpected(): void
    {
        $rules = $this->rules->toArray();
        self::assertIsArray($rules);
    }
}
