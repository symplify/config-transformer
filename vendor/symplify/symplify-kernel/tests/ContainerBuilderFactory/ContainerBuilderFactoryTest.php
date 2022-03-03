<?php

declare (strict_types=1);
namespace ConfigTransformer2022030310\Symplify\SymplifyKernel\Tests\ContainerBuilderFactory;

use ConfigTransformer2022030310\PHPUnit\Framework\TestCase;
use ConfigTransformer2022030310\Symplify\SmartFileSystem\SmartFileSystem;
use ConfigTransformer2022030310\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer2022030310\Symplify\SymplifyKernel\ContainerBuilderFactory;
final class ContainerBuilderFactoryTest extends \ConfigTransformer2022030310\PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $containerBuilderFactory = new \ConfigTransformer2022030310\Symplify\SymplifyKernel\ContainerBuilderFactory(new \ConfigTransformer2022030310\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $container = $containerBuilderFactory->create([__DIR__ . '/config/some_services.php'], [], []);
        $hasSmartFileSystemService = $container->has(\ConfigTransformer2022030310\Symplify\SmartFileSystem\SmartFileSystem::class);
        $this->assertTrue($hasSmartFileSystemService);
    }
}
