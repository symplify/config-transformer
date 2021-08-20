<?php

declare (strict_types=1);
namespace ConfigTransformer202108209\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202108209\PhpParser\Node\Arg;
use ConfigTransformer202108209\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202108209\PhpParser\Node\Expr\Variable;
use ConfigTransformer202108209\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202108209\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202108209\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202108209\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202108209\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class NameOnlyServiceCaseConverter implements \ConfigTransformer202108209\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\ConfigTransformer202108209\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer202108209\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $setMethodCall = new \ConfigTransformer202108209\PhpParser\Node\Expr\MethodCall(new \ConfigTransformer202108209\PhpParser\Node\Expr\Variable(\ConfigTransformer202108209\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), 'set', [new \ConfigTransformer202108209\PhpParser\Node\Arg($classConstFetch)]);
        return new \ConfigTransformer202108209\PhpParser\Node\Stmt\Expression($setMethodCall);
    }
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer202108209\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $values === null || $values === [];
    }
}
