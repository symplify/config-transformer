<?php

declare (strict_types=1);
namespace ConfigTransformer202107058\Symplify\Astral\HttpKernel;

use ConfigTransformer202107058\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202107058\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \ConfigTransformer202107058\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer202107058\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
