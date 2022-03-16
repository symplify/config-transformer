<?php

declare (strict_types=1);
namespace ConfigTransformer202203162\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202203162\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202203162\PhpParser\Node\Expr\Variable;
use ConfigTransformer202203162\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202203162\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202203162\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory;
use ConfigTransformer202203162\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202203162\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202203162\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ServicesDefaultsCaseConverter implements \ConfigTransformer202203162\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory
     */
    private $autoBindNodeFactory;
    public function __construct(\ConfigTransformer202203162\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202203162\PhpParser\Node\Stmt\Expression
    {
        $methodCall = new \ConfigTransformer202203162\PhpParser\Node\Expr\MethodCall($this->createServicesVariable(), \ConfigTransformer202203162\Symplify\PhpConfigPrinter\ValueObject\MethodName::DEFAULTS);
        $decoratedMethodCall = $this->autoBindNodeFactory->createAutoBindCalls($values, $methodCall, \ConfigTransformer202203162\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory::TYPE_DEFAULTS);
        return new \ConfigTransformer202203162\PhpParser\Node\Stmt\Expression($decoratedMethodCall);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer202203162\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $key === \ConfigTransformer202203162\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_DEFAULTS;
    }
    private function createServicesVariable() : \ConfigTransformer202203162\PhpParser\Node\Expr\Variable
    {
        return new \ConfigTransformer202203162\PhpParser\Node\Expr\Variable(\ConfigTransformer202203162\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
    }
}
