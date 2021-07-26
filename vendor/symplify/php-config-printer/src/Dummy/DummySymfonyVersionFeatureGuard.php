<?php

declare (strict_types=1);
namespace ConfigTransformer202107264\Symplify\PhpConfigPrinter\Dummy;

use ConfigTransformer202107264\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
final class DummySymfonyVersionFeatureGuard implements \ConfigTransformer202107264\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
{
    /**
     * @param float $symfonyVersion
     */
    public function isAtLeastSymfonyVersion($symfonyVersion) : bool
    {
        return \true;
    }
}
