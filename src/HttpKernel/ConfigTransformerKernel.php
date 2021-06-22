<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210\Symplify\ConfigTransformer\HttpKernel;

use ConfigTransformer2021062210\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021062210\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use ConfigTransformer2021062210\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use ConfigTransformer2021062210\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ConfigTransformerKernel extends \ConfigTransformer2021062210\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer2021062210\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \ConfigTransformer2021062210\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \ConfigTransformer2021062210\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
