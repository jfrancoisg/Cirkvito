<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;

return [
    'preset' => 'symfony',
    'exclude' => [],
    'add' => [
        \NunoMaduro\PhpInsights\Domain\Metrics\Code\Comments::class => [
            \PhpCsFixer\Fixer\Phpdoc\PhpdocSummaryFixer::class,
        ],
    ],
    'remove' => [],
    'ide' => 'vscode',
    'config' => [
        LineLengthSniff::class => [
            'lineLimit' => 80,
            'absoluteLineLimit' => 80,
            'ignoreComments' => false,
        ],
    ],
    'requirements' => [
        'min-quality' => 90.0,
        'min-complexity' => 90.0,
        'min-architecture' => 90.0,
        'min-style' => 100.0,
    ],
];
