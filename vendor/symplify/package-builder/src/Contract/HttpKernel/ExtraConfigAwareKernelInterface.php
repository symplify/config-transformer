<?php

declare (strict_types=1);
namespace ConfigTransformer202108203\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202108203\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202108203\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202108203\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
