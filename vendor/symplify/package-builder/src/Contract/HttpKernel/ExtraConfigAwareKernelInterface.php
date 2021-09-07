<?php

declare (strict_types=1);
namespace ConfigTransformer202109079\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202109079\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202109079\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202109079\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
