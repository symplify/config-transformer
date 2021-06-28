<?php

declare (strict_types=1);
namespace ConfigTransformer202106280\Symplify\PhpConfigPrinter\HttpKernel;

use ConfigTransformer202106280\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202106280\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer202106280\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use ConfigTransformer202106280\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use ConfigTransformer202106280\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class PhpConfigPrinterKernel extends \ConfigTransformer202106280\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel implements \ConfigTransformer202106280\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface
{
    /**
     * @var string[]
     */
    private $configs = [];
    public function registerContainerConfiguration(\ConfigTransformer202106280\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
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
        return [new \ConfigTransformer202106280\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
    /**
     * @param string[] $configs
     */
    public function setConfigs(array $configs) : void
    {
        $this->configs = $configs;
    }
}
