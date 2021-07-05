<?php

declare (strict_types=1);
namespace ConfigTransformer202107056\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202107056\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202107056\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202107056\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
