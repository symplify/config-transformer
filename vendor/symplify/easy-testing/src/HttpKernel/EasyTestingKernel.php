<?php

declare (strict_types=1);
namespace ConfigTransformer2021072110\Symplify\EasyTesting\HttpKernel;

use ConfigTransformer2021072110\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021072110\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer2021072110\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
