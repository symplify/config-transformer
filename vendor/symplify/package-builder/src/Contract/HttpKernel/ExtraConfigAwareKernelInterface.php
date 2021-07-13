<?php

declare (strict_types=1);
namespace ConfigTransformer202107131\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202107131\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202107131\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202107131\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
