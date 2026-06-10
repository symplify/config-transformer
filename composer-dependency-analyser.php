<?php

declare(strict_types=1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

$config = new Configuration();

return $config
    // required for project config parsing
    ->ignoreErrorsOnPackage('symfony/expression-language', [ErrorType::UNUSED_DEPENDENCY])

    // php-config-printer prints MyCLabs enums, but only as an optional runtime feature
    ->ignoreErrorsOnPackage('myclabs/php-enum', [ErrorType::DEV_DEPENDENCY_IN_PROD])

    // test fixtures
    ->addPathToExclude(__DIR__ . '/tests/Converter/ConfigFormatConverter/YamlToPhp/Source');
