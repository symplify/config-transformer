<?php

declare (strict_types=1);
namespace ConfigTransformer202109282\Symplify\EasyTesting\HttpKernel;

use ConfigTransformer202109282\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202109282\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202109282\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
