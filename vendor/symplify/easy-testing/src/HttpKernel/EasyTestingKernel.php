<?php

declare (strict_types=1);
namespace ConfigTransformer2021092210\Symplify\EasyTesting\HttpKernel;

use ConfigTransformer2021092210\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021092210\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer2021092210\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
