<?php

declare (strict_types=1);
namespace ConfigTransformer202111019\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202111019\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202111019\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202111019\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
