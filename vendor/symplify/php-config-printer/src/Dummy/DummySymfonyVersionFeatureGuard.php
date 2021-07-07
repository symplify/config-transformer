<?php

declare (strict_types=1);
namespace ConfigTransformer2021070710\Symplify\PhpConfigPrinter\Dummy;

use ConfigTransformer2021070710\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
final class DummySymfonyVersionFeatureGuard implements \ConfigTransformer2021070710\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
{
    public function isAtLeastSymfonyVersion(float $symfonyVersion) : bool
    {
        return \true;
    }
}
