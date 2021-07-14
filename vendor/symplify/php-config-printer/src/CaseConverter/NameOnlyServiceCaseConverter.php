<?php

declare (strict_types=1);
namespace ConfigTransformer202107149\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202107149\PhpParser\Node\Arg;
use ConfigTransformer202107149\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202107149\PhpParser\Node\Expr\Variable;
use ConfigTransformer202107149\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202107149\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202107149\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202107149\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202107149\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class NameOnlyServiceCaseConverter implements \ConfigTransformer202107149\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\ConfigTransformer202107149\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer202107149\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $setMethodCall = new \ConfigTransformer202107149\PhpParser\Node\Expr\MethodCall(new \ConfigTransformer202107149\PhpParser\Node\Expr\Variable(\ConfigTransformer202107149\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), 'set', [new \ConfigTransformer202107149\PhpParser\Node\Arg($classConstFetch)]);
        return new \ConfigTransformer202107149\PhpParser\Node\Stmt\Expression($setMethodCall);
    }
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer202107149\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $values === null || $values === [];
    }
}
