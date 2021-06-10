<?php

declare (strict_types=1);
namespace ConfigTransformer20210610\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer20210610\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer20210610\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer20210610\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void;
}
