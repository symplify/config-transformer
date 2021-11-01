<?php

declare (strict_types=1);
namespace ConfigTransformer202111016\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202111016\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202111016\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202111016\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
