<?php

declare (strict_types=1);
namespace ConfigTransformer20220610;

use ConfigTransformer20220610\PhpParser\BuilderFactory;
use ConfigTransformer20220610\PhpParser\NodeFinder;
use ConfigTransformer20220610\Symfony\Component\Console\Application;
use ConfigTransformer20220610\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer20220610\Symfony\Component\Yaml\Parser;
use Symplify\ConfigTransformer\Command\SwitchFormatCommand;
use ConfigTransformer20220610\Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use ConfigTransformer20220610\Symplify\PackageBuilder\Yaml\ParametersMerger;
use ConfigTransformer20220610\Symplify\SmartFileSystem\FileSystemFilter;
use function ConfigTransformer20220610\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->load('Symplify\\ConfigTransformer\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Kernel', __DIR__ . '/../src/DependencyInjection/Loader', __DIR__ . '/../src/Enum', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(Application::class)->call('add', [service(SwitchFormatCommand::class)]);
    $services->set(BuilderFactory::class);
    $services->set(NodeFinder::class);
    $services->set(Parser::class);
    $services->set(FileSystemFilter::class);
    $services->set(ClassLikeExistenceChecker::class);
    $services->set(ParametersMerger::class);
};
