<?php

declare (strict_types=1);
namespace ConfigTransformer202205096\Symplify\SymplifyKernel\Tests\ContainerBuilderFactory;

use ConfigTransformer202205096\PHPUnit\Framework\TestCase;
use ConfigTransformer202205096\Symplify\SmartFileSystem\SmartFileSystem;
use ConfigTransformer202205096\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer202205096\Symplify\SymplifyKernel\ContainerBuilderFactory;
final class ContainerBuilderFactoryTest extends \ConfigTransformer202205096\PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $containerBuilderFactory = new \ConfigTransformer202205096\Symplify\SymplifyKernel\ContainerBuilderFactory(new \ConfigTransformer202205096\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $containerBuilder = $containerBuilderFactory->create([__DIR__ . '/config/some_services.php'], [], []);
        $hasSmartFileSystemService = $containerBuilder->has(\ConfigTransformer202205096\Symplify\SmartFileSystem\SmartFileSystem::class);
        $this->assertTrue($hasSmartFileSystemService);
    }
}
