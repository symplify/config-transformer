<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php81\Rector\MethodCall\MyCLabsMethodCallToEnumConstRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        PHPUnitSetList::PHPUNIT_100,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        LevelSetList::UP_TO_PHP_81,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::CODING_STYLE,
        SetList::TYPE_DECLARATION,
        SetList::NAMING,
        SetList::PRIVATIZATION,
        SetList::EARLY_RETURN,
    ]);

    $rectorConfig->paths([
        __DIR__ . '/bin',
        __DIR__ . '/config',
        __DIR__ . '/packages',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->importNames();

    $rectorConfig->skip([
        '*/scoper.php',
        '*/Source/*',
        '*/Fixture/*',

        // reads the key from an arbitrary runtime MyCLabs enum, not a native enum migration
        MyCLabsMethodCallToEnumConstRector::class => [
            __DIR__ . '/packages/php-config-printer/src/NodeFactory/NewValueObjectFactory.php',
        ],
    ]);
};
