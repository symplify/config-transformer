<?php

declare (strict_types=1);
namespace ConfigTransformer2021081110\Symplify\ConfigTransformer\HttpKernel;

use ConfigTransformer2021081110\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021081110\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer2021081110\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use ConfigTransformer2021081110\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use ConfigTransformer2021081110\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ConfigTransformerKernel extends \ConfigTransformer2021081110\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
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
        return [new \ConfigTransformer2021081110\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \ConfigTransformer2021081110\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
