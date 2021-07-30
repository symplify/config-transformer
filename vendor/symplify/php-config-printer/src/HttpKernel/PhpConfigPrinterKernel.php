<?php

declare (strict_types=1);
namespace ConfigTransformer202107300\Symplify\PhpConfigPrinter\HttpKernel;

use ConfigTransformer202107300\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202107300\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer202107300\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use ConfigTransformer202107300\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use ConfigTransformer202107300\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class PhpConfigPrinterKernel extends \ConfigTransformer202107300\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel implements \ConfigTransformer202107300\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
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
        return [new \ConfigTransformer202107300\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
    /**
     * @param string[] $configs
     */
    public function setConfigs($configs) : void
    {
        $this->configs = $configs;
    }
}
