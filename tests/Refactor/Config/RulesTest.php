<?php
namespace Refactor\Config;

use PHPUnit\Framework\TestCase;

/**
 * Class RulesTest
 * @package Refactor\Config
 */
class RulesTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function validateRuleObjectTypes(): void
    {
        if (file_exists(\Refactor\Utility\PathUtility::getRefactorItRulesFile())) {
            $rules = new \Refactor\Config\Rules();
            $json = file_get_contents(\Refactor\Utility\PathUtility::getRefactorItRulesFile());
            $rules->fromJSON(json_decode($json, true));

            $this->assertIsArray($rules->getOrderedClassElements());
            $this->assertIsArray($rules->getArraySyntax());
            $this->assertIsArray($rules->getConcatSpace());

            $this->assertIsBool($rules->isPhpdocTrim());
            $this->assertIsBool($rules->isPhpdocOrder());
            $this->assertIsBool($rules->isPhpdocScalar());
            $this->assertIsBool($rules->isPhpdocTypes());
            $this->assertIsBool($rules->isOrderedImports());
            $this->assertIsBool($rules->isBlankLineBeforeReturn());
            $this->assertIsBool($rules->isNoBlankLinesBeforeNamespace());
            $this->assertIsBool($rules->isNoBlankLinesAfterPhpdoc());
            $this->assertIsBool($rules->isNoEmptyPhpdoc());
            $this->assertIsBool($rules->isNoEmptyStatement());

            $this->assertIsArray($rules->getNoMixedEchoPrint());

            $this->assertIsBool($rules->isNoTrailingWhitespace());
            $this->assertIsBool($rules->isNoUnusedImports());
            $this->assertIsBool($rules->isNoWhitespaceInBlankLine());
            $this->assertIsBool($rules->isObjectOperatorWithoutWhitespace());
            $this->assertIsBool($rules->isFunctionTypehintSpace());

            $this->assertIsArray($rules->getNoExtraConsecutiveBlankLines());

            $this->assertIsBool($rules->isPhpdocAddMissingParamAnnotation());
            $this->assertIsBool($rules->isNull());
            $this->assertIsBool($rules->isLinebreakAfterOpeningTag());
            $this->assertIsBool($rules->isLowercaseCast());
        }
    }
}
