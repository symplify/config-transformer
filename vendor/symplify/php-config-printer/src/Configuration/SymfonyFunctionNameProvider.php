<?php

declare (strict_types=1);
namespace ConfigTransformer202108166\Symplify\PhpConfigPrinter\Configuration;

use ConfigTransformer202108166\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use ConfigTransformer202108166\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
use ConfigTransformer202108166\Symplify\PhpConfigPrinter\ValueObject\SymfonyVersionFeature;
final class SymfonyFunctionNameProvider
{
    /**
     * @var \Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
     */
    private $symfonyVersionFeatureGuard;
    public function __construct(\ConfigTransformer202108166\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface $symfonyVersionFeatureGuard)
    {
        $this->symfonyVersionFeatureGuard = $symfonyVersionFeatureGuard;
    }
    public function provideRefOrService() : string
    {
        if ($this->symfonyVersionFeatureGuard->isAtLeastSymfonyVersion(\ConfigTransformer202108166\Symplify\PhpConfigPrinter\ValueObject\SymfonyVersionFeature::REF_OVER_SERVICE)) {
            return \ConfigTransformer202108166\Symplify\PhpConfigPrinter\ValueObject\FunctionName::SERVICE;
        }
        return \ConfigTransformer202108166\Symplify\PhpConfigPrinter\ValueObject\FunctionName::REF;
    }
}
