<?php

declare (strict_types=1);
namespace ConfigTransformer2021061110\Symplify\Astral\HttpKernel;

use ConfigTransformer2021061110\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021061110\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \ConfigTransformer2021061110\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer2021061110\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
