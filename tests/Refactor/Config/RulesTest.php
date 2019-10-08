<?php

namespace Refactor\Config;

use PHPUnit\Framework\TestCase;

/**
 * Class RulesTest
 * @package Refactor\Config
 */
class RulesTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        /** @var \Refactor\Config\Rules $rules */
        $rules = new \Refactor\Config\Rules();

        $rules->setOrderedClassElements([]);
        $rules->setArraySyntax(['syntax' => 'long']);
        $rules->setConcatSpace([]);
        $rules->setPhpdocTrim(false);
        $rules->setPhpdocOrder(true);
        $rules->setPhpdocScalar(true);
        $rules->setOrderedImports(true);
        $rules->setBlankLineBeforeReturn(false);
        $rules->setNoBlankLinesBeforeNamespace(false);
        $rules->setNoBlankLinesAfterPhpdoc(true);
        $rules->setNoEmptyPhpdoc(true);
        $rules->setNoEmptyStatement(true);
        $rules->setNoMixedEchoPrint(['use' => 'echo']);
        $rules->setNoTrailingWhitespace(false);
        $rules->setNoUnusedImports(true);
        $rules->setNoWhitespaceInBlankLine(true);
        $rules->setObjectOperatorWithoutWhitespace(true);
        $rules->setFunctionTypehintSpace(true);
        $rules->setNoExtraConsecutiveBlankLines(['token' => ['test']]);
        $rules->setPhpdocAddMissingParamAnnotation(false);
        $rules->setIsNull(true);
        $rules->setLinebreakAfterOpeningTag(false);
        $rules->setLowercaseCast(true);

        $this->assertEmpty($rules->getOrderedClassElements());
        $this->assertIsArray($rules->getArraySyntax());
        $this->assertEmpty($rules->getConcatSpace());
        $this->assertFalse($rules->isPhpdocTrim());
        $this->assertTrue($rules->isPhpdocOrder());
        $this->assertTrue($rules->isPhpdocScalar());
        $this->assertTrue($rules->isOrderedImports());
        $this->assertFalse($rules->isBlankLineBeforeReturn());
        $this->assertFalse($rules->isNoBlankLinesBeforeNamespace());
        $this->assertTrue($rules->isNoBlankLinesAfterPhpdoc());
        $this->assertTrue($rules->isNoEmptyPhpdoc());
        $this->assertTrue($rules->isNoEmptyStatement());
        $this->assertArrayHasKey('use', $rules->getNoMixedEchoPrint());
        $this->assertFalse($rules->isNoTrailingWhitespace());
        $this->assertTrue($rules->isNoUnusedImports());
        $this->assertTrue($rules->isNoWhitespaceInBlankLine());
        $this->assertTrue($rules->isObjectOperatorWithoutWhitespace());
        $this->assertTrue($rules->isFunctionTypehintSpace());
        $this->assertArrayHasKey('token', $rules->getNoExtraConsecutiveBlankLines());
        $this->assertFalse($rules->isPhpdocAddMissingParamAnnotation());
        $this->assertTrue($rules->isNull());
        $this->assertFalse($rules->isLinebreakAfterOpeningTag());
        $this->assertTrue($rules->isLowercaseCast());
    }
}