<?php

declare (strict_types=1);
namespace ConfigTransformer2021061910\Symplify\SymplifyKernel\HttpKernel;

use ConfigTransformer2021061910\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021061910\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer2021061910\Symfony\Component\HttpKernel\Kernel;
use ConfigTransformer2021061910\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use ConfigTransformer2021061910\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer2021061910\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use ConfigTransformer2021061910\Symplify\SymplifyKernel\Strings\KernelUniqueHasher;
abstract class AbstractSymplifyKernel extends \ConfigTransformer2021061910\Symfony\Component\HttpKernel\Kernel implements \ConfigTransformer2021061910\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
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
        return [new \ConfigTransformer2021061910\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle()];
    }
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs(array $configs) : void
    {
        foreach ($configs as $config) {
            if ($config instanceof \ConfigTransformer2021061910\Symplify\SmartFileSystem\SmartFileInfo) {
                $config = $config->getRealPath();
            }
            $this->configs[] = $config;
        }
    }
    public function registerContainerConfiguration(\ConfigTransformer2021061910\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        foreach ($this->configs as $config) {
            $loader->load($config);
        }
    }
    private function getUniqueKernelHash() : string
    {
        $kernelUniqueHasher = new \ConfigTransformer2021061910\Symplify\SymplifyKernel\Strings\KernelUniqueHasher();
        return $kernelUniqueHasher->hashKernelClass(static::class);
    }
}
