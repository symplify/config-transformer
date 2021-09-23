<?php

declare (strict_types=1);
namespace ConfigTransformer202109238\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202109238\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202109238\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202109238\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
