<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710;

use ConfigTransformer2022060710\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer2022060710\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2022060710\Symplify\ComposerJsonManipulator\ValueObject\Option;
use ConfigTransformer2022060710\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer2022060710\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer2022060710\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use ConfigTransformer2022060710\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer2022060710\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->load('Symplify\\ComposerJsonManipulator\\', __DIR__ . '/../src');
    $services->set(SmartFileSystem::class);
    $services->set(PrivatesCaller::class);
    $services->set(ParameterProvider::class)->args([service('service_container')]);
    $services->set(SymfonyStyleFactory::class);
    $services->set(SymfonyStyle::class)->factory([service(SymfonyStyleFactory::class), 'create']);
};
