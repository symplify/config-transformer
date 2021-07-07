<?php

declare (strict_types=1);
namespace ConfigTransformer202107073\Symplify\Astral\HttpKernel;

use ConfigTransformer202107073\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202107073\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \ConfigTransformer202107073\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer202107073\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
