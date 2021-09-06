<?php

declare (strict_types=1);
namespace ConfigTransformer2021090610\Symplify\ConfigTransformer\HttpKernel;

use ConfigTransformer2021090610\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021090610\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer2021090610\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use ConfigTransformer2021090610\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use ConfigTransformer2021090610\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ConfigTransformerKernel extends \ConfigTransformer2021090610\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \ConfigTransformer2021090610\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \ConfigTransformer2021090610\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
