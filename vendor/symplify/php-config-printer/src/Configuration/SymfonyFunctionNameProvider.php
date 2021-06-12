<?php

declare (strict_types=1);
namespace ConfigTransformer202106125\Symplify\PhpConfigPrinter\Configuration;

use ConfigTransformer202106125\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use ConfigTransformer202106125\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
use ConfigTransformer202106125\Symplify\PhpConfigPrinter\ValueObject\SymfonyVersionFeature;
final class SymfonyFunctionNameProvider
{
    /**
     * @var SymfonyVersionFeatureGuardInterface
     */
    private $symfonyVersionFeatureGuard;
    public function __construct(\ConfigTransformer202106125\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface $symfonyVersionFeatureGuard)
    {
        $this->symfonyVersionFeatureGuard = $symfonyVersionFeatureGuard;
    }
    public function provideRefOrService() : string
    {
        if ($this->symfonyVersionFeatureGuard->isAtLeastSymfonyVersion(\ConfigTransformer202106125\Symplify\PhpConfigPrinter\ValueObject\SymfonyVersionFeature::REF_OVER_SERVICE)) {
            return \ConfigTransformer202106125\Symplify\PhpConfigPrinter\ValueObject\FunctionName::SERVICE;
        }
        return \ConfigTransformer202106125\Symplify\PhpConfigPrinter\ValueObject\FunctionName::REF;
    }
}
