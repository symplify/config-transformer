<?php

declare (strict_types=1);
namespace ConfigTransformer202202162;

use ConfigTransformer202202162\PhpParser\BuilderFactory;
use ConfigTransformer202202162\PhpParser\NodeFinder;
use ConfigTransformer202202162\Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202202162\Symfony\Component\Yaml\Parser;
use ConfigTransformer202202162\Symplify\ConfigTransformer\Command\SwitchFormatCommand;
use ConfigTransformer202202162\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use ConfigTransformer202202162\Symplify\PackageBuilder\Yaml\ParametersMerger;
use ConfigTransformer202202162\Symplify\SmartFileSystem\FileSystemFilter;
use function ConfigTransformer202202162\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202202162\Symplify\ConfigTransformer\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Kernel', __DIR__ . '/../src/DependencyInjection/Loader', __DIR__ . '/../src/Enum', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(\ConfigTransformer202202162\Symfony\Component\Console\Application::class)->call('add', [\ConfigTransformer202202162\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202202162\Symplify\ConfigTransformer\Command\SwitchFormatCommand::class)]);
    $services->set(\ConfigTransformer202202162\PhpParser\BuilderFactory::class);
    $services->set(\ConfigTransformer202202162\PhpParser\NodeFinder::class);
    $services->set(\ConfigTransformer202202162\Symfony\Component\Yaml\Parser::class);
    $services->set(\ConfigTransformer202202162\Symplify\SmartFileSystem\FileSystemFilter::class);
    $services->set(\ConfigTransformer202202162\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker::class);
    $services->set(\ConfigTransformer202202162\Symplify\PackageBuilder\Yaml\ParametersMerger::class);
};
