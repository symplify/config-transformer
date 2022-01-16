<?php

declare (strict_types=1);
namespace ConfigTransformer202201163;

use ConfigTransformer202201163\PhpParser\BuilderFactory;
use ConfigTransformer202201163\PhpParser\NodeFinder;
use ConfigTransformer202201163\Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202201163\Symfony\Component\Yaml\Parser;
use ConfigTransformer202201163\Symplify\ConfigTransformer\Command\SwitchFormatCommand;
use ConfigTransformer202201163\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use ConfigTransformer202201163\Symplify\PackageBuilder\Yaml\ParametersMerger;
use ConfigTransformer202201163\Symplify\SmartFileSystem\FileSystemFilter;
use function ConfigTransformer202201163\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202201163\Symplify\ConfigTransformer\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Kernel', __DIR__ . '/../src/DependencyInjection/Loader', __DIR__ . '/../src/Enum', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer202201163\Symfony\Component\Console\Application::class)->call('add', [\ConfigTransformer202201163\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202201163\Symplify\ConfigTransformer\Command\SwitchFormatCommand::class)]);
    $services->set(\ConfigTransformer202201163\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer202201163\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer202201163\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer202201163\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\ConfigTransformer202201163\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
    $services->set(\ConfigTransformer202201163\Symplify\PackageBuilder\Yaml\ParametersMerger::class);
};
