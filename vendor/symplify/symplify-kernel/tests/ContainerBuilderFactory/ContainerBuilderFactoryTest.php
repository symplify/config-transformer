<?php

declare (strict_types=1);
namespace ConfigTransformer20220610\Symplify\SymplifyKernel\Tests\ContainerBuilderFactory;

use ConfigTransformer20220610\PHPUnit\Framework\TestCase;
use ConfigTransformer20220610\Symplify\SmartFileSystem\SmartFileSystem;
use ConfigTransformer20220610\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer20220610\Symplify\SymplifyKernel\ContainerBuilderFactory;
final class ContainerBuilderFactoryTest extends TestCase
{
    public function test() : void
    {
        $containerBuilderFactory = new ContainerBuilderFactory(new ParameterMergingLoaderFactory());
        $containerBuilder = $containerBuilderFactory->create([__DIR__ . '/config/some_services.php'], [], []);
        $hasSmartFileSystemService = $containerBuilder->has(SmartFileSystem::class);
        $this->assertTrue($hasSmartFileSystemService);
    }
}
