<?php
namespace Refactor\Config;

use Refactor\Common\JsonParserInterface;

/**
 * Class DefaultRules
 * @package Refactor\Config
 */
class Rules implements JsonParserInterface
{
    public const RULES_FILE = 'rules.json';

    /** @var array */
    protected $orderedClassElements = [
        'use_trait',
        'constant_public',
        'constant_protected',
        'constant_private',
        'property_public',
        'property_protected',
        'property_private',
        'construct',
        'destruct',
        'magic'
    ];

    /** @var array */
    protected $arraySyntax = [
        'syntax' => 'short'
    ];

    /** @var array */
    protected $concatSpace = [
        'spacing' => 'one'
    ];

    /** @var bool */
    protected $phpdocTrim = true;

    /** @var bool */
    protected $phpdocOrder = true;

    /** @var bool */
    protected $phpdocScalar = true;

    /** @var bool */
    protected $phpdocTypes = true;

    /** @var bool */
    protected $orderedImports = true;

    /** @var bool */
    protected $blankLineBeforeReturn = true;

    /** @var bool */
    protected $noBlankLinesBeforeNamespace = true;

    /** @var bool */
    protected $noBlankLinesAfterPhpdoc = true;

    /** @var bool */
    protected $noEmptyPhpdoc = true;

    /** @var bool */
    protected $noEmptyStatement = true;

    /** @var array */
    protected $noMixedEchoPrint = [
        'use' => 'echo'
    ];

    /** @var bool */
    protected $noTrailingWhitespace = true;

    /** @var bool */
    protected $noUnusedImports = true;

    /** @var bool */
    protected $noWhitespaceInBlankLine = true;

    /** @var bool */
    protected $objectOperatorWithoutWhitespace = true;

    /** @var bool */
    protected $functionTypehintSpace = true;

    /** @var array */
    protected $noExtraConsecutiveBlankLines = [
        'tokens' => [
            'extra'
        ]
    ];

    /** @var bool */
    protected $phpdocAddMissingParamAnnotation = true;

    /** @var bool */
    protected $isNull = true;

    /** @var bool */
    protected $linebreakAfterOpeningTag = true;

    /** @var bool */
    protected $lowercaseCast = true;

    /**
     * @return array
     */
    public function getOrderedClassElements(): array
    {
        return $this->orderedClassElements;
    }

    /**
     * @param array $orderedClassElements
     */
    public function setOrderedClassElements(array $orderedClassElements)
    {
        $this->orderedClassElements = $orderedClassElements;
    }

    /**
     * @return array
     */
    public function getArraySyntax(): array
    {
        return $this->arraySyntax;
    }

    /**
     * @param array $arraySyntax
     */
    public function setArraySyntax(array $arraySyntax)
    {
        $this->arraySyntax = $arraySyntax;
    }

    /**
     * @return array
     */
    public function getConcatSpace(): array
    {
        return $this->concatSpace;
    }

    /**
     * @param array $concatSpace
     */
    public function setConcatSpace(array $concatSpace)
    {
        $this->concatSpace = $concatSpace;
    }

    /**
     * @return bool
     */
    public function isPhpdocTrim(): bool
    {
        return $this->phpdocTrim;
    }

    /**
     * @param bool $phpdocTrim
     */
    public function setPhpdocTrim(bool $phpdocTrim)
    {
        $this->phpdocTrim = $phpdocTrim;
    }

    /**
     * @return bool
     */
    public function isPhpdocOrder(): bool
    {
        return $this->phpdocOrder;
    }

    /**
     * @param bool $phpdocOrder
     */
    public function setPhpdocOrder(bool $phpdocOrder)
    {
        $this->phpdocOrder = $phpdocOrder;
    }

    /**
     * @return bool
     */
    public function isPhpdocScalar(): bool
    {
        return $this->phpdocScalar;
    }

    /**
     * @param bool $phpdocScalar
     */
    public function setPhpdocScalar(bool $phpdocScalar)
    {
        $this->phpdocScalar = $phpdocScalar;
    }

    /**
     * @return bool
     */
    public function isPhpdocTypes(): bool
    {
        return $this->phpdocTypes;
    }

    /**
     * @param bool $phpdocTypes
     */
    public function setPhpdocTypes(bool $phpdocTypes)
    {
        $this->phpdocTypes = $phpdocTypes;
    }

    /**
     * @return bool
     */
    public function isOrderedImports(): bool
    {
        return $this->orderedImports;
    }

    /**
     * @param bool $orderedImports
     */
    public function setOrderedImports(bool $orderedImports)
    {
        $this->orderedImports = $orderedImports;
    }

    /**
     * @return bool
     */
    public function isBlankLineBeforeReturn(): bool
    {
        return $this->blankLineBeforeReturn;
    }

    /**
     * @param bool $blankLineBeforeReturn
     */
    public function setBlankLineBeforeReturn(bool $blankLineBeforeReturn)
    {
        $this->blankLineBeforeReturn = $blankLineBeforeReturn;
    }

    /**
     * @return bool
     */
    public function isNoBlankLinesBeforeNamespace(): bool
    {
        return $this->noBlankLinesBeforeNamespace;
    }

    /**
     * @param bool $noBlankLinesBeforeNamespace
     */
    public function setNoBlankLinesBeforeNamespace(bool $noBlankLinesBeforeNamespace)
    {
        $this->noBlankLinesBeforeNamespace = $noBlankLinesBeforeNamespace;
    }

    /**
     * @return bool
     */
    public function isNoBlankLinesAfterPhpdoc(): bool
    {
        return $this->noBlankLinesAfterPhpdoc;
    }

    /**
     * @param bool $noBlankLinesAfterPhpdoc
     */
    public function setNoBlankLinesAfterPhpdoc(bool $noBlankLinesAfterPhpdoc)
    {
        $this->noBlankLinesAfterPhpdoc = $noBlankLinesAfterPhpdoc;
    }

    /**
     * @return bool
     */
    public function isNoEmptyPhpdoc(): bool
    {
        return $this->noEmptyPhpdoc;
    }

    /**
     * @param bool $noEmptyPhpdoc
     */
    public function setNoEmptyPhpdoc(bool $noEmptyPhpdoc)
    {
        $this->noEmptyPhpdoc = $noEmptyPhpdoc;
    }

    /**
     * @return bool
     */
    public function isNoEmptyStatement(): bool
    {
        return $this->noEmptyStatement;
    }

    /**
     * @param bool $noEmptyStatement
     */
    public function setNoEmptyStatement(bool $noEmptyStatement)
    {
        $this->noEmptyStatement = $noEmptyStatement;
    }

    /**
     * @return array
     */
    public function getNoMixedEchoPrint(): array
    {
        return $this->noMixedEchoPrint;
    }

    /**
     * @param array $noMixedEchoPrint
     */
    public function setNoMixedEchoPrint(array $noMixedEchoPrint)
    {
        $this->noMixedEchoPrint = $noMixedEchoPrint;
    }

    /**
     * @return bool
     */
    public function isNoTrailingWhitespace(): bool
    {
        return $this->noTrailingWhitespace;
    }

    /**
     * @param bool $noTrailingWhitespace
     */
    public function setNoTrailingWhitespace(bool $noTrailingWhitespace)
    {
        $this->noTrailingWhitespace = $noTrailingWhitespace;
    }

    /**
     * @return bool
     */
    public function isNoUnusedImports(): bool
    {
        return $this->noUnusedImports;
    }

    /**
     * @param bool $noUnusedImports
     */
    public function setNoUnusedImports(bool $noUnusedImports)
    {
        $this->noUnusedImports = $noUnusedImports;
    }

    /**
     * @return bool
     */
    public function isNoWhitespaceInBlankLine(): bool
    {
        return $this->noWhitespaceInBlankLine;
    }

    /**
     * @param bool $noWhitespaceInBlankLine
     */
    public function setNoWhitespaceInBlankLine(bool $noWhitespaceInBlankLine)
    {
        $this->noWhitespaceInBlankLine = $noWhitespaceInBlankLine;
    }

    /**
     * @return bool
     */
    public function isObjectOperatorWithoutWhitespace(): bool
    {
        return $this->objectOperatorWithoutWhitespace;
    }

    /**
     * @param bool $objectOperatorWithoutWhitespace
     */
    public function setObjectOperatorWithoutWhitespace(bool $objectOperatorWithoutWhitespace)
    {
        $this->objectOperatorWithoutWhitespace = $objectOperatorWithoutWhitespace;
    }

    /**
     * @return bool
     */
    public function isFunctionTypehintSpace(): bool
    {
        return $this->functionTypehintSpace;
    }

    /**
     * @param bool $functionTypehintSpace
     */
    public function setFunctionTypehintSpace(bool $functionTypehintSpace)
    {
        $this->functionTypehintSpace = $functionTypehintSpace;
    }

    /**
     * @return array
     */
    public function getNoExtraConsecutiveBlankLines(): array
    {
        return $this->noExtraConsecutiveBlankLines;
    }

    /**
     * @param array $noExtraConsecutiveBlankLines
     */
    public function setNoExtraConsecutiveBlankLines(array $noExtraConsecutiveBlankLines)
    {
        $this->noExtraConsecutiveBlankLines = $noExtraConsecutiveBlankLines;
    }

    /**
     * @return bool
     */
    public function isPhpdocAddMissingParamAnnotation(): bool
    {
        return $this->phpdocAddMissingParamAnnotation;
    }

    /**
     * @param bool $phpdocAddMissingParamAnnotation
     */
    public function setPhpdocAddMissingParamAnnotation(bool $phpdocAddMissingParamAnnotation)
    {
        $this->phpdocAddMissingParamAnnotation = $phpdocAddMissingParamAnnotation;
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return $this->isNull;
    }

    /**
     * @param bool $isNull
     */
    public function setIsNull(bool $isNull)
    {
        $this->isNull = $isNull;
    }

    /**
     * @return bool
     */
    public function isLinebreakAfterOpeningTag(): bool
    {
        return $this->linebreakAfterOpeningTag;
    }

    /**
     * @param bool $linebreakAfterOpeningTag
     */
    public function setLinebreakAfterOpeningTag(bool $linebreakAfterOpeningTag)
    {
        $this->linebreakAfterOpeningTag = $linebreakAfterOpeningTag;
    }

    /**
     * @return bool
     */
    public function isLowercaseCast(): bool
    {
        return $this->lowercaseCast;
    }

    /**
     * @param bool $lowercaseCast
     */
    public function setLowercaseCast(bool $lowercaseCast)
    {
        $this->lowercaseCast = $lowercaseCast;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $properties = [];
        $variables = get_object_vars($this);

        foreach ($variables as $key => $value) {
            $snakeCased = preg_replace('/[A-Z]/', '_$0', $key);
            $snakeCased = strtolower($snakeCased);
            $snakeCasedKey = ltrim($snakeCased, '_');
            $properties[$snakeCasedKey] = $value;
        }

        $properties = array_merge($properties, ['@PSR2' => true]);

        return $properties;
    }

    /**
     * @param array $json
     * @return Rules
     */
    public function fromJSON(array $json): Rules
    {
        if (isset($json['ordered_class_elements']) && is_array($json['ordered_class_elements']) && count($json['ordered_class_elements']) > 0) {
            $this->setOrderedClassElements($json['ordered_class_elements']);
        }

        if (isset($json['array_syntax']) && is_array($json['array_syntax']) && count($json['array_syntax']) > 0) {
            $this->setArraySyntax($json['array_syntax']);
        }

        if (isset($json['concat_space']) && is_array($json['concat_space']) && count($json['concat_space']) > 0) {
            $this->setConcatSpace($json['concat_space']);
        }

        if (isset($json['phpdoc_trim']) && is_bool($json['phpdoc_trim'])) {
            $this->setphpdocTrim($json['phpdoc_trim']);
        }

        if (isset($json['phpdoc_order']) && is_bool($json['phpdoc_order'])) {
            $this->setPhpdocOrder($json['phpdoc_order']);
        }

        if (isset($json['phpdoc_scalar']) && is_bool($json['phpdoc_scalar'])) {
            $this->setPhpdocScalar($json['phpdoc_scalar']);
        }

        if (isset($json['phpdoc_types']) && is_bool($json['phpdoc_types'])) {
            $this->setPhpdocTypes($json['phpdoc_types']);
        }

        if (isset($json['ordered_imports']) && is_bool($json['ordered_imports'])) {
            $this->setOrderedImports($json['ordered_imports']);
        }

        if (isset($json['blank_lines_before_return']) && is_bool($json['blank_lines_before_return'])) {
            $this->setBlankLineBeforeReturn($json['blank_lines_before_return']);
        }

        if (isset($json['no_blank_lines_before_namespace']) && is_bool($json['no_blank_lines_before_namespace'])) {
            $this->setNoBlankLinesBeforeNamespace($json['no_blank_lines_before_namespace']);
        }

        if (isset($json['no_blank_lines_after_phpdoc']) && is_bool($json['no_blank_lines_after_phpdoc'])) {
            $this->setNoBlankLinesAfterPhpdoc($json['no_blank_lines_after_phpdoc']);
        }

        if (isset($json['no_empty_phpdoc']) && is_bool($json['no_empty_phpdoc'])) {
            $this->setNoEmptyPhpdoc($json['no_empty_phpdoc']);
        }

        if (isset($json['no_empty_statement']) && is_bool($json['no_empty_statement'])) {
            $this->setNoEmptyStatement($json['no_empty_statement']);
        }

        if (isset($json['no_mixed_echo_print']) && is_array($json['no_mixed_echo_print']) && count($json['no_mixed_echo_print']) > 0) {
            $this->setNoMixedEchoPrint($json['no_mixed_echo_print']);
        }

        if (isset($json['no_extra_consecutive_blank_lines']) && is_array($json['no_extra_consecutive_blank_lines']) && count($json['no_extra_consecutive_blank_lines']) > 0) {
            $this->setNoExtraConsecutiveBlankLines($json['no_extra_consecutive_blank_lines']);
        }

        if (isset($json['no_trailing_whitespace']) && is_bool($json['no_trailing_whitespace'])) {
            $this->setNoTrailingWhitespace($json['no_trailing_whitespace']);
        }

        if (isset($json['no_unused_imports']) && is_bool($json['no_unused_imports'])) {
            $this->setNoUnusedImports($json['no_unused_imports']);
        }

        if (isset($json['no_whitespace_in_blank_line']) && is_bool($json['no_whitespace_in_blank_line'])) {
            $this->setNoWhitespaceInBlankLine($json['no_whitespace_in_blank_line']);
        }

        if (isset($json['object_operator_without_whitespace']) && is_bool($json['object_operator_without_whitespace'])) {
            $this->setObjectOperatorWithoutWhitespace($json['object_operator_without_whitespace']);
        }

        if (isset($json['function_typehint_space']) && is_bool($json['function_typehint_space'])) {
            $this->setFunctionTypehintSpace($json['function_typehint_space']);
        }

        if (isset($json['phpdoc_add_missing_param_annotation']) && is_bool($json['phpdoc_add_missing_param_annotation'])) {
            $this->setPhpdocAddMissingParamAnnotation($json['phpdoc_add_missing_param_annotation']);
        }

        if (isset($json['is_null']) && is_bool($json['is_null'])) {
            $this->setIsNull($json['is_null']);
        }

        if (isset($json['linebreak_after_opening_tag']) && is_bool($json['linebreak_after_opening_tag'])) {
            $this->setLinebreakAfterOpeningTag($json['linebreak_after_opening_tag']);
        }

        if (isset($json['lowercase_cast']) && is_bool($json['lowercase_cast'])) {
            $this->setLowercaseCast($json['lowercase_cast']);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function toJSON(): string
    {
        $properties = [];
        $variables = get_object_vars($this);

        foreach ($variables as $key => $value) {
            $snakeCased = preg_replace('/[A-Z]/', '_$0', $key);
            $snakeCased = strtolower($snakeCased);
            $snakeCasedKey = ltrim($snakeCased, '_');
            $properties[$snakeCasedKey] = $value;
        }

        $properties = array_merge($properties, ['@PSR2' => true]);

        return json_encode(array_filter($properties, function ($value) {
            return $value !== null;
        }), JSON_PRETTY_PRINT);
    }
}
