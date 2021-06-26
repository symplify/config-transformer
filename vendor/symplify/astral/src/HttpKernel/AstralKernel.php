<?php

declare (strict_types=1);
namespace ConfigTransformer202106266\Symplify\Astral\HttpKernel;

use ConfigTransformer202106266\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202106266\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \ConfigTransformer202106266\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer202106266\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
