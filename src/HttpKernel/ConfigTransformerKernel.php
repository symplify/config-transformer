<?php

declare (strict_types=1);
namespace ConfigTransformer2021070510\Symplify\ConfigTransformer\HttpKernel;

use ConfigTransformer2021070510\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021070510\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer2021070510\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use ConfigTransformer2021070510\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use ConfigTransformer2021070510\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ConfigTransformerKernel extends \ConfigTransformer2021070510\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer2021070510\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \ConfigTransformer2021070510\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \ConfigTransformer2021070510\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
