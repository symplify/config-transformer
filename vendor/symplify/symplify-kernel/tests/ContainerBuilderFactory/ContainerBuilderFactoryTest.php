<?php

declare (strict_types=1);
namespace ConfigTransformer202204182\Symplify\SymplifyKernel\Tests\ContainerBuilderFactory;

use ConfigTransformer202204182\PHPUnit\Framework\TestCase;
use ConfigTransformer202204182\Symplify\SmartFileSystem\SmartFileSystem;
use ConfigTransformer202204182\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer202204182\Symplify\SymplifyKernel\ContainerBuilderFactory;
final class ContainerBuilderFactoryTest extends \ConfigTransformer202204182\PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $containerBuilderFactory = new \ConfigTransformer202204182\Symplify\SymplifyKernel\ContainerBuilderFactory(new \ConfigTransformer202204182\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $container = $containerBuilderFactory->create([__DIR__ . '/config/some_services.php'], [], []);
        $hasSmartFileSystemService = $container->has(\ConfigTransformer202204182\Symplify\SmartFileSystem\SmartFileSystem::class);
        $this->assertTrue($hasSmartFileSystemService);
    }
}
