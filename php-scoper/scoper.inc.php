<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Isolated\Symfony\Component\Finder\Finder;

return [
    // The prefix configuration. If a non null value will be used, a random prefix will be generated.
    'prefix' => 'Dekode\\GravityForms\\Vendor',

    // Only scope runtime dependencies, not dev tools (PHPCS, WPCS, etc.).
    //
    // For more see: https://github.com/humbug/php-scoper#finders-and-paths
    'finders' => [
        Finder::create()
            ->files()
            ->name('*.*')
            ->ignoreVCS(true)
            ->in('vendor/microsoft')
            ->in('vendor/guzzlehttp')
            ->in('vendor/psr')
            ->in('vendor/ralouphie')
            ->in('vendor/symfony'),
    ],

    // If `true` then the user defined constants belonging to the global namespace will not be prefixed.
    //
    // For more see https://github.com/humbug/php-scoper#constants--constants--functions-from-the-global-namespace
    'expose-global-constants' => false,

    // If `true` then the user defined classes belonging to the global namespace will not be prefixed.
    //
    // For more see https://github.com/humbug/php-scoper#constants--constants--functions-from-the-global-namespace
    'expose-global-classes' => false,

    // If `true` then the user defined functions belonging to the global namespace will not be prefixed.
    //
    // For more see https://github.com/humbug/php-scoper#constants--constants--functions-from-the-global-namespace
    'expose-global-functions' => false,
];
