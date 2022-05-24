<?php

declare (strict_types=1);
namespace ConfigTransformer2022052410\Symplify\SymplifyKernel\Tests\ContainerBuilderFactory;

use ConfigTransformer2022052410\PHPUnit\Framework\TestCase;
use ConfigTransformer2022052410\Symplify\SmartFileSystem\SmartFileSystem;
use ConfigTransformer2022052410\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer2022052410\Symplify\SymplifyKernel\ContainerBuilderFactory;
final class ContainerBuilderFactoryTest extends \ConfigTransformer2022052410\PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $containerBuilderFactory = new \ConfigTransformer2022052410\Symplify\SymplifyKernel\ContainerBuilderFactory(new \ConfigTransformer2022052410\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $containerBuilder = $containerBuilderFactory->create([__DIR__ . '/config/some_services.php'], [], []);
        $hasSmartFileSystemService = $containerBuilder->has(\ConfigTransformer2022052410\Symplify\SmartFileSystem\SmartFileSystem::class);
        $this->assertTrue($hasSmartFileSystemService);
    }
}
