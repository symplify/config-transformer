<?php

declare (strict_types=1);
namespace ConfigTransformer202109182\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202109182\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202109182\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202109182\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
