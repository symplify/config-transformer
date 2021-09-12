<?php

declare (strict_types=1);
namespace ConfigTransformer202109129\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202109129\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202109129\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202109129\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
