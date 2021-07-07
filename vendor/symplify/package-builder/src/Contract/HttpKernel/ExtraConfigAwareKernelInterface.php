<?php

declare (strict_types=1);
namespace ConfigTransformer202107079\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202107079\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202107079\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202107079\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
