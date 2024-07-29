<?php

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__ . '/src', __DIR__ . '/tests'])
;

return Retailcrm\PhpCsFixer\Defaults::rules([
    '@PSR12' => true,
    'global_namespace_import' => false,
    'phpdoc_align' => ['align' => 'left'],
    'no_extra_blank_lines' => true,
    'types_spaces' => false,
    'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
    'void_return' => false,
])->setFinder($finder)
    // ->setCacheFile(__DIR__ . '/var/cache/.php_cs.cache')
    ;
