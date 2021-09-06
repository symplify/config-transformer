<?php

declare (strict_types=1);
namespace ConfigTransformer2021090610\Symplify\Astral\HttpKernel;

use ConfigTransformer2021090610\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021090610\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \ConfigTransformer2021090610\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
