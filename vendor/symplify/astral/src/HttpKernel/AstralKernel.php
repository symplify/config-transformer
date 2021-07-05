<?php

declare (strict_types=1);
namespace ConfigTransformer2021070510\Symplify\Astral\HttpKernel;

use ConfigTransformer2021070510\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer2021070510\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class AstralKernel extends \ConfigTransformer2021070510\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer2021070510\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
