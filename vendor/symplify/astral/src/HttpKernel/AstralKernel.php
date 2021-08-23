<?php

declare (strict_types=1);
namespace ConfigTransformer202108233\Symplify\Astral\HttpKernel;

use ConfigTransformer202108233\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202108233\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \ConfigTransformer202108233\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
