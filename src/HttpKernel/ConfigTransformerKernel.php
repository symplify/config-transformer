<?php

declare (strict_types=1);
namespace ConfigTransformer202107088\Symplify\ConfigTransformer\HttpKernel;

use ConfigTransformer202107088\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202107088\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer202107088\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use ConfigTransformer202107088\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use ConfigTransformer202107088\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ConfigTransformerKernel extends \ConfigTransformer202107088\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer202107088\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \ConfigTransformer202107088\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \ConfigTransformer202107088\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
