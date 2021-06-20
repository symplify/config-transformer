<?php

declare (strict_types=1);
namespace ConfigTransformer202106207\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202106207\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202106207\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202106207\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
