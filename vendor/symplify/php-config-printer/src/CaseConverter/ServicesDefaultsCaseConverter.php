<?php

declare (strict_types=1);
namespace ConfigTransformer202106120\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202106120\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202106120\PhpParser\Node\Expr\Variable;
use ConfigTransformer202106120\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202106120\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202106120\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory;
use ConfigTransformer202106120\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202106120\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202106120\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ServicesDefaultsCaseConverter implements \ConfigTransformer202106120\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory
     */
    private $autoBindNodeFactory;
    public function __construct(\ConfigTransformer202106120\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer202106120\PhpParser\Node\Stmt\Expression
    {
        $methodCall = new \ConfigTransformer202106120\PhpParser\Node\Expr\MethodCall($this->createServicesVariable(), \ConfigTransformer202106120\Symplify\PhpConfigPrinter\ValueObject\MethodName::DEFAULTS);
        $methodCall = $this->autoBindNodeFactory->createAutoBindCalls($values, $methodCall, \ConfigTransformer202106120\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory::TYPE_DEFAULTS);
        return new \ConfigTransformer202106120\PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer202106120\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $key === \ConfigTransformer202106120\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_DEFAULTS;
    }
    private function createServicesVariable() : \ConfigTransformer202106120\PhpParser\Node\Expr\Variable
    {
        return new \ConfigTransformer202106120\PhpParser\Node\Expr\Variable(\ConfigTransformer202106120\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
    }
}
