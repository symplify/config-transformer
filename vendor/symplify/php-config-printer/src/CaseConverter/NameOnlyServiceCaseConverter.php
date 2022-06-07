<?php

declare (strict_types=1);
namespace ConfigTransformer202206075\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202206075\PhpParser\Node\Arg;
use ConfigTransformer202206075\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202206075\PhpParser\Node\Expr\Variable;
use ConfigTransformer202206075\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202206075\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202206075\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202206075\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202206075\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class NameOnlyServiceCaseConverter implements CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $setMethodCall = new MethodCall(new Variable(VariableName::SERVICES), 'set', [new Arg($classConstFetch)]);
        return new Expression($setMethodCall);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== YamlKey::SERVICES) {
            return \false;
        }
        return $values === null || $values === [];
    }
}
