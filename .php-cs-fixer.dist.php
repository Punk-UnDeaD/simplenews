<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['var', 'vendor']);

return (new PhpCsFixer\Config())
    ->setRules(
        [
            '@Symfony'                  => true,
            '@PSR12'                    => true,
            'array_syntax'              => ['syntax' => 'short'],
            'single_line_comment_style' => [],
            'phpdoc_to_comment'         => false,
            'cast_spaces'               => ['space' => 'none'],
            'function_declaration'      => ['closure_function_spacing' => 'none'],
            'binary_operator_spaces'    => [
                'operators' => ['=>' => 'align_single_space'],
            ],
        ]
    )
    ->setFinder($finder);
