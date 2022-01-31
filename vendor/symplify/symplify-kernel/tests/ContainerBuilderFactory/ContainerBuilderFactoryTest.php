<?php

declare (strict_types=1);
namespace ConfigTransformer202201310\Symplify\SymplifyKernel\Tests\ContainerBuilderFactory;

use ConfigTransformer202201310\PHPUnit\Framework\TestCase;
use ConfigTransformer202201310\Symplify\SmartFileSystem\SmartFileSystem;
use ConfigTransformer202201310\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer202201310\Symplify\SymplifyKernel\ContainerBuilderFactory;
final class ContainerBuilderFactoryTest extends \ConfigTransformer202201310\PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $containerBuilderFactory = new \ConfigTransformer202201310\Symplify\SymplifyKernel\ContainerBuilderFactory(new \ConfigTransformer202201310\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $container = $containerBuilderFactory->create([__DIR__ . '/config/some_services.php'], [], []);
        $hasSmartFileSystemService = $container->has(\ConfigTransformer202201310\Symplify\SmartFileSystem\SmartFileSystem::class);
        $this->assertTrue($hasSmartFileSystemService);
    }
}
