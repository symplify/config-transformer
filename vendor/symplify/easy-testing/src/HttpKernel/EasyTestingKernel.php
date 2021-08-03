<?php

declare (strict_types=1);
namespace ConfigTransformer202108033\Symplify\EasyTesting\HttpKernel;

use ConfigTransformer202108033\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202108033\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202108033\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
