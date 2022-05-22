<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210\Symplify\EasyTesting\Kernel;

use ConfigTransformer2022052210\Psr\Container\ContainerInterface;
use ConfigTransformer2022052210\Symplify\EasyTesting\ValueObject\EasyTestingConfig;
use ConfigTransformer2022052210\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer2022052210\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer2022052210\Psr\Container\ContainerInterface
    {
        $configFiles[] = \ConfigTransformer2022052210\Symplify\EasyTesting\ValueObject\EasyTestingConfig::FILE_PATH;
        return $this->create($configFiles);
    }
}
