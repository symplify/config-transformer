<?php

declare (strict_types=1);
namespace ConfigTransformer2021072110\Symplify\PhpConfigPrinter\HttpKernel;

use ConfigTransformer2021072110\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021072110\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer2021072110\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use ConfigTransformer2021072110\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use ConfigTransformer2021072110\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class PhpConfigPrinterKernel extends \ConfigTransformer2021072110\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel implements \ConfigTransformer2021072110\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
{
    /**
     * @var string[]
     */
    private $configs = [];
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        foreach ($this->configs as $config) {
            $loader->load($config);
        }
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \ConfigTransformer2021072110\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
    /**
     * @param string[] $configs
     */
    public function setConfigs($configs) : void
    {
        $this->configs = $configs;
    }
}
