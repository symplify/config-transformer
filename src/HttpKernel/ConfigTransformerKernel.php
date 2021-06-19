<?php

declare (strict_types=1);
namespace ConfigTransformer202106196\Symplify\ConfigTransformer\HttpKernel;

use ConfigTransformer202106196\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202106196\Symfony\Component\HttpKernel\Bundle\BundleInterface;
use ConfigTransformer202106196\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use ConfigTransformer202106196\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use ConfigTransformer202106196\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ConfigTransformerKernel extends \ConfigTransformer202106196\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer202106196\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
    /**
     * @return BundleInterface[]
     */
    public function registerBundles() : iterable
    {
        return [new \ConfigTransformer202106196\Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle(), new \ConfigTransformer202106196\Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle()];
    }
}
