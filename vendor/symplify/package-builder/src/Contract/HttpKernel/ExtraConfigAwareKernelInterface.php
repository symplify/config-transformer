<?php

declare (strict_types=1);
namespace ConfigTransformer202110072\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202110072\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202110072\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202110072\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
