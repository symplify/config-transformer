<?php

declare (strict_types=1);
namespace ConfigTransformer202109067\Symplify\SymplifyKernel\HttpKernel;

use ConfigTransformer202109067\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202109067\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer202109067\Symfony\Component\HttpKernel\Kernel;
use ConfigTransformer202109067\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use ConfigTransformer202109067\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer202109067\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use ConfigTransformer202109067\Symplify\SymplifyKernel\Strings\KernelUniqueHasher;
abstract class AbstractSymplifyKernel extends \ConfigTransformer202109067\Symfony\Component\HttpKernel\Kernel implements \ConfigTransformer202109067\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
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
        return [new \ConfigTransformer202109067\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void
    {
        foreach ($configs as $config) {
            if ($config instanceof \ConfigTransformer202109067\Symplify\SmartFileSystem\SmartFileInfo) {
                $config = $config->getRealPath();
            }
            $this->configs[] = $config;
        }
    }
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        foreach ($this->configs as $config) {
            $loader->load($config);
        }
    }
    private function getUniqueKernelHash() : string
    {
        $kernelUniqueHasher = new \ConfigTransformer202109067\Symplify\SymplifyKernel\Strings\KernelUniqueHasher();
        return $kernelUniqueHasher->hashKernelClass(static::class);
    }
}
