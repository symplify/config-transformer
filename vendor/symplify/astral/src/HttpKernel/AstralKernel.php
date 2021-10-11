<?php

declare (strict_types=1);
namespace ConfigTransformer2021101110\Symplify\Astral\HttpKernel;

use ConfigTransformer2021101110\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021101110\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \ConfigTransformer2021101110\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
