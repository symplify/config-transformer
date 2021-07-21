<?php

declare (strict_types=1);
namespace ConfigTransformer2021072110\Symplify\PhpConfigPrinter\Dummy;

use ConfigTransformer2021072110\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
final class DummySymfonyVersionFeatureGuard implements \ConfigTransformer2021072110\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
{
    /**
     * @param float $symfonyVersion
     */
    public function isAtLeastSymfonyVersion($symfonyVersion) : bool
    {
        return \true;
    }
}
