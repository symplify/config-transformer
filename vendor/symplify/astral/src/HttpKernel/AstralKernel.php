<?php

declare (strict_types=1);
namespace ConfigTransformer202108258\Symplify\Astral\HttpKernel;

use ConfigTransformer202108258\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202108258\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \ConfigTransformer202108258\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
