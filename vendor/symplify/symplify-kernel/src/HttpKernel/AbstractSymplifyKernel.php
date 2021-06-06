<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\Symplify\SymplifyKernel\HttpKernel;

use ConfigTransformer20210606\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer20210606\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer20210606\Symfony\Component\HttpKernel\Kernel;
use ConfigTransformer20210606\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use ConfigTransformer20210606\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer20210606\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use ConfigTransformer20210606\Symplify\SymplifyKernel\Strings\KernelUniqueHasher;
abstract class AbstractSymplifyKernel extends \ConfigTransformer20210606\Symfony\Component\HttpKernel\Kernel implements \ConfigTransformer20210606\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
{
    /**
     * @var string[]
     */
    private $configs = [];
    public function getCacheDir() : string
    {
        return \sys_get_temp_dir() . '/' . $this->getUniqueKernelHash();
    }
    public function getLogDir() : string
    {
        return \sys_get_temp_dir() . '/' . $this->getUniqueKernelHash() . '_log';
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \ConfigTransformer20210606\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void
    {
        foreach ($configs as $config) {
            if ($config instanceof \ConfigTransformer20210606\Symplify\SmartFileSystem\SmartFileInfo) {
                $config = $config->getRealPath();
            }
            $this->configs[] = $config;
        }
    }
    public function registerContainerConfiguration(\ConfigTransformer20210606\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        foreach ($this->configs as $config) {
            $loader->load($config);
        }
    }
    private function getUniqueKernelHash() : string
    {
        $kernelUniqueHasher = new \ConfigTransformer20210606\Symplify\SymplifyKernel\Strings\KernelUniqueHasher();
        return $kernelUniqueHasher->hashKernelClass(static::class);
    }
}
