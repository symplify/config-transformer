<?php

declare (strict_types=1);
namespace ConfigTransformer202109208\Symplify\EasyTesting\HttpKernel;

use ConfigTransformer202109208\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202109208\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202109208\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
