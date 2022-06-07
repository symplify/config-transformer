<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\EasyTesting\Kernel;

use ConfigTransformer2022060710\Psr\Container\ContainerInterface;
use ConfigTransformer2022060710\Symplify\EasyTesting\ValueObject\EasyTestingConfig;
use ConfigTransformer2022060710\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : ContainerInterface
    {
        $configFiles[] = EasyTestingConfig::FILE_PATH;
        return $this->create($configFiles);
    }
}
