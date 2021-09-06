<?php

declare (strict_types=1);
namespace ConfigTransformer202109063\Symplify\Astral\HttpKernel;

use ConfigTransformer202109063\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202109063\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \ConfigTransformer202109063\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
