<?php
namespace Refactor\Config;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

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
     * @param string $json
     * @return Rules
     */
    public function fromJSON(string $json): Rules
    {
        $serializer = new Serializer([new GetSetMethodNormalizer()], [new JsonEncoder()]);
        $serializer->deserialize($json, __CLASS__, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $this]);

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
