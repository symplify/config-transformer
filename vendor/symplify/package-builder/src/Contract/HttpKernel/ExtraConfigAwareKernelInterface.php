<?php

declare (strict_types=1);
namespace ConfigTransformer202110015\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202110015\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202110015\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202110015\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
