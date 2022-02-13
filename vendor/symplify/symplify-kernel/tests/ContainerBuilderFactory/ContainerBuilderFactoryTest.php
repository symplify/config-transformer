<?php

declare (strict_types=1);
namespace ConfigTransformer202202134\Symplify\SymplifyKernel\Tests\ContainerBuilderFactory;

use ConfigTransformer202202134\PHPUnit\Framework\TestCase;
use ConfigTransformer202202134\Symplify\SmartFileSystem\SmartFileSystem;
use ConfigTransformer202202134\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer202202134\Symplify\SymplifyKernel\ContainerBuilderFactory;
final class ContainerBuilderFactoryTest extends \ConfigTransformer202202134\PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $containerBuilderFactory = new \ConfigTransformer202202134\Symplify\SymplifyKernel\ContainerBuilderFactory(new \ConfigTransformer202202134\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $container = $containerBuilderFactory->create([__DIR__ . '/config/some_services.php'], [], []);
        $hasSmartFileSystemService = $container->has(\ConfigTransformer202202134\Symplify\SmartFileSystem\SmartFileSystem::class);
        $this->assertTrue($hasSmartFileSystemService);
    }
}
