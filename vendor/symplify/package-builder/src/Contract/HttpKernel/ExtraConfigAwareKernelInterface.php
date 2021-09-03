<?php

declare (strict_types=1);
namespace ConfigTransformer202109036\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202109036\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202109036\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202109036\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
