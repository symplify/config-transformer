<?php

declare (strict_types=1);
namespace ConfigTransformer202107246\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202107246\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202107246\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202107246\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
