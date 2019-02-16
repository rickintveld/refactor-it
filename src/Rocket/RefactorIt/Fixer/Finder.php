<?php
namespace Rocket\RefactorIt\Fixer;

/**
 * Class Finder
 * @package Rocket\RefactorIt\Fixer
 */
class Finder
{

    public function findAdjustedFiles()
    {
        $finder = \PhpCsFixer\Finder::create()->exclude('vendor')->in('src');

        return \PhpCsFixer\Config::create()
            ->setRules([
                '@PSR2' => true,
                'ordered_class_elements' => [
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
                ],
                'array_syntax' => [
                    'syntax' => 'short'
                ],
                'concat_space' => [
                    'spacing' => 'one',
                ],
                'phpdoc_trim' => true,
                'phpdoc_order' => true,
                'phpdoc_scalar' => true,
                'phpdoc_types' => true,
                'ordered_imports' => true,
                'blank_line_before_return' => true,
                'no_blank_lines_before_namespace' => true,
                'no_blank_lines_after_phpdoc' => true,
                'no_empty_phpdoc' => true,
                'no_empty_statement' => true,
                'no_mixed_echo_print' => ['use' => 'echo'],
                'no_trailing_whitespace' => true,
                'no_unused_imports' => true,
                'no_whitespace_in_blank_line' => true,
                'object_operator_without_whitespace' => true,
                'function_typehint_space' => true,
                'no_extra_consecutive_blank_lines' => [
                    'tokens' => ['extra'],
                ],
                'phpdoc_add_missing_param_annotation' => true,
                'is_null' => true,
                'linebreak_after_opening_tag' => true,
                'lowercase_cast' => true,
            ])
            ->setIndent("\t")
            ->setLineEnding("\r\n")
            ->setFormat('php')
            ->setFinder($finder);
    }
}