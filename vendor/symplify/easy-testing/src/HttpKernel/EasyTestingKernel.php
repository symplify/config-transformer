<?php

declare (strict_types=1);
namespace ConfigTransformer202107071\Symplify\EasyTesting\HttpKernel;

use ConfigTransformer202107071\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202107071\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202107071\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer202107071\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
