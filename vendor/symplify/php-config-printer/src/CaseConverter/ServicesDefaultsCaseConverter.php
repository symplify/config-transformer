<?php

declare (strict_types=1);
namespace ConfigTransformer202107276\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202107276\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202107276\PhpParser\Node\Expr\Variable;
use ConfigTransformer202107276\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202107276\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202107276\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory;
use ConfigTransformer202107276\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202107276\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202107276\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ServicesDefaultsCaseConverter implements \ConfigTransformer202107276\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory
     */
    private $autoBindNodeFactory;
    public function __construct(\ConfigTransformer202107276\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer202107276\PhpParser\Node\Stmt\Expression
    {
        $methodCall = new \ConfigTransformer202107276\PhpParser\Node\Expr\MethodCall($this->createServicesVariable(), \ConfigTransformer202107276\Symplify\PhpConfigPrinter\ValueObject\MethodName::DEFAULTS);
        $decoratedMethodCall = $this->autoBindNodeFactory->createAutoBindCalls($values, $methodCall, \ConfigTransformer202107276\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory::TYPE_DEFAULTS);
        return new \ConfigTransformer202107276\PhpParser\Node\Stmt\Expression($decoratedMethodCall);
    }
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer202107276\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $key === \ConfigTransformer202107276\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_DEFAULTS;
    }
    private function createServicesVariable() : \ConfigTransformer202107276\PhpParser\Node\Expr\Variable
    {
        return new \ConfigTransformer202107276\PhpParser\Node\Expr\Variable(\ConfigTransformer202107276\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
    }
}
