<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202507;

use ConfigTransformerPrefix202507\ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ConfigTransformerPrefix202507\ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;
// include ref() function
// require __DIR__ . '/vendor/symfony/dependency-injection/Loader/Configurator/ContainerConfigurator.php';
$configuration = new Configuration();
// can be used conditionally, based on project context
$configuration->ignoreErrorsOnPackage('myclabs/php-enum', [ErrorType::DEV_DEPENDENCY_IN_PROD]);
return $configuration;
