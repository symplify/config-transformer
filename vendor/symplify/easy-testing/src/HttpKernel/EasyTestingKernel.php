<?php

declare (strict_types=1);
namespace ConfigTransformer202107084\Symplify\EasyTesting\HttpKernel;

use ConfigTransformer202107084\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202107084\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202107084\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer202107084\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
