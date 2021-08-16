<?php

declare (strict_types=1);
namespace ConfigTransformer2021081610\Symplify\PhpConfigPrinter\Configuration;

use ConfigTransformer2021081610\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use ConfigTransformer2021081610\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
use ConfigTransformer2021081610\Symplify\PhpConfigPrinter\ValueObject\SymfonyVersionFeature;
final class SymfonyFunctionNameProvider
{
    /**
     * @var \Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
     */
    private $symfonyVersionFeatureGuard;
    public function __construct(\ConfigTransformer2021081610\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface $symfonyVersionFeatureGuard)
    {
        $this->symfonyVersionFeatureGuard = $symfonyVersionFeatureGuard;
    }
    public function provideRefOrService() : string
    {
        if ($this->symfonyVersionFeatureGuard->isAtLeastSymfonyVersion(\ConfigTransformer2021081610\Symplify\PhpConfigPrinter\ValueObject\SymfonyVersionFeature::REF_OVER_SERVICE)) {
            return \ConfigTransformer2021081610\Symplify\PhpConfigPrinter\ValueObject\FunctionName::SERVICE;
        }
        return \ConfigTransformer2021081610\Symplify\PhpConfigPrinter\ValueObject\FunctionName::REF;
    }
}
