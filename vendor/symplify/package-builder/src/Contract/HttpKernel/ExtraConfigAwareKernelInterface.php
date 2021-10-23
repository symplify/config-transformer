<?php

declare (strict_types=1);
namespace ConfigTransformer202110235\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202110235\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202110235\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202110235\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
