<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__.'/dev',
        __DIR__.'/src',
        __DIR__.'/tests'
    ]);

$header = <<<EOF
This file is part of the Serendipity HQ Stripe Bundle.

Copyright (c) Adamo Aerendir Crespi <aerendir@serendipityhq.com>.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$config = new PhpCsFixer\Config();
$config
    ->setFinder($finder)
    ->setUsingCache(true)
    ->setCacheFile(__DIR__.'/var/cache/.php_cs.cache')
    ->setRiskyAllowed(true)
    ->setRules([
       'header_comment' => ['header' => $header],
       '@Symfony' => true,

       // Symfony overwritings
       'binary_operator_spaces' => [
           'default' => 'align',
       ],
       'concat_space' => ['spacing' => 'one'],
       'phpdoc_to_comment' => false,

       // Other rules
       'align_multiline_comment' => true,
       'array_syntax' => ['syntax' => 'short'],
       'blank_line_before_statement' => true,
       'combine_consecutive_unsets' => true,
       'linebreak_after_opening_tag' => true,
       'list_syntax' => ['syntax' => 'short'],
       'multiline_whitespace_before_semicolons' => true,
       'no_null_property_initialization' => true,
       'echo_tag_syntax' => true,
       'no_superfluous_phpdoc_tags' => false,
       'no_unreachable_default_argument_value' => true,
       'no_useless_else' => true,
       'no_useless_return' => true,
       'not_operator_with_space' => true,
       'not_operator_with_successor_space' => true,
       'ordered_class_elements' => [
           'order' => [
               'use_trait',
               'constant_public',
               'constant_protected',
               'constant_private',
               'property_public',
               'property_protected',
               'property_private',
               'construct',
               'phpunit',
               'method_public',
               'method_protected',
               'method_private',
               'destruct',
               'magic'
           ]
       ],
       'ordered_imports' => true,
       'phpdoc_add_missing_param_annotation' => true,
       'phpdoc_line_span' => [
           'const' => 'single',
           'method' => 'multi',
           'property' => 'single',
       ],
       'phpdoc_order' => true,
       'phpdoc_types_order' => ['null_adjustment' => 'always_last'],
       'phpdoc_var_without_name' => false,
       'single_line_comment_style' => ['comment_types' => ['hash']],
       'strict_comparison' => true
   ]);

return $config;
