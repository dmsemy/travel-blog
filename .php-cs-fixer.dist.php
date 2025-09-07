<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')
    ->exclude(['var', 'vendor'])
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,

        // Rules that are not in @Symfony but are highly recommended
        'strict_comparison' => true,
        'strict_param' => true,
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'visibility_required' => true,
        'nullable_type_declaration_for_default_null_value' => true,

        // Rules that are in @Symfony, but we are overriding their defaults
        'class_attributes_separation' => ['elements' => ['method' => 'one', 'trait_import' => 'one']],

        // Additional rules for better code consistency and readability
        'trailing_comma_in_multiline' => ['elements' => ['arrays', 'arguments', 'parameters', 'match']],
        'ordered_class_elements' => [
            'order' => [
                'use_trait', 'constant_public', 'constant_protected', 'constant_private',
                'property_public', 'property_protected', 'property_private',
                'construct', 'destruct', 'magic', 'phpunit',
                'method_public', 'method_protected', 'method_private',
            ],
        ],
        'list_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;
