<?php

declare (strict_types=1);
namespace ConfigTransformer202106115\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202106115\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202106115\PhpParser\Node\Expr\Variable;
use ConfigTransformer202106115\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202106115\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202106115\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory;
use ConfigTransformer202106115\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202106115\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202106115\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ServicesDefaultsCaseConverter implements \ConfigTransformer202106115\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var AutoBindNodeFactory
     */
    private $autoBindNodeFactory;
    public function __construct(\ConfigTransformer202106115\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer202106115\PhpParser\Node\Stmt\Expression
    {
        $methodCall = new \ConfigTransformer202106115\PhpParser\Node\Expr\MethodCall($this->createServicesVariable(), \ConfigTransformer202106115\Symplify\PhpConfigPrinter\ValueObject\MethodName::DEFAULTS);
        $methodCall = $this->autoBindNodeFactory->createAutoBindCalls($values, $methodCall, \ConfigTransformer202106115\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory::TYPE_DEFAULTS);
        return new \ConfigTransformer202106115\PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer202106115\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $key === \ConfigTransformer202106115\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_DEFAULTS;
    }
    private function createServicesVariable() : \ConfigTransformer202106115\PhpParser\Node\Expr\Variable
    {
        return new \ConfigTransformer202106115\PhpParser\Node\Expr\Variable(\ConfigTransformer202106115\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
    }
}
