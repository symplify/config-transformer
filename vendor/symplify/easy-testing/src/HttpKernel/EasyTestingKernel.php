<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\Symplify\EasyTesting\HttpKernel;

use ConfigTransformer20210606\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer20210606\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer20210606\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    public function registerContainerConfiguration(\ConfigTransformer20210606\Symfony\Component\Config\Loader\LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
