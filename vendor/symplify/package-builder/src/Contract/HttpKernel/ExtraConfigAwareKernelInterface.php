<?php

declare (strict_types=1);
namespace ConfigTransformer202110071\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202110071\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202110071\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202110071\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
