<?php

declare (strict_types=1);
namespace ConfigTransformer202106129\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202106129\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202106129\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202106129\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
