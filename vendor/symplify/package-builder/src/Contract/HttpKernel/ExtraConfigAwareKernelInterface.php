<?php

declare (strict_types=1);
namespace ConfigTransformer202107061\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202107061\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202107061\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202107061\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
