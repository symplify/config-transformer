<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformerPrefix202301\PhpParser\Node\Arg;
use ConfigTransformerPrefix202301\PhpParser\Node\Expr\MethodCall;
use ConfigTransformerPrefix202301\PhpParser\Node\Expr\Variable;
use ConfigTransformerPrefix202301\PhpParser\Node\Stmt;
use ConfigTransformerPrefix202301\PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
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
    public function convertToMethodCallStmt($key, $values) : Stmt
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
