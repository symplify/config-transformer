<?php

declare (strict_types=1);
namespace ConfigTransformer2021090610\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer2021090610\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021090610\PhpParser\Node\Expr\Variable;
use ConfigTransformer2021090610\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2021090610\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer2021090610\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory;
use ConfigTransformer2021090610\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer2021090610\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer2021090610\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ServicesDefaultsCaseConverter implements \ConfigTransformer2021090610\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory
     */
    private $autoBindNodeFactory;
    public function __construct(\ConfigTransformer2021090610\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021090610\PhpParser\Node\Stmt\Expression
    {
        $methodCall = new \ConfigTransformer2021090610\PhpParser\Node\Expr\MethodCall($this->createServicesVariable(), \ConfigTransformer2021090610\Symplify\PhpConfigPrinter\ValueObject\MethodName::DEFAULTS);
        $decoratedMethodCall = $this->autoBindNodeFactory->createAutoBindCalls($values, $methodCall, \ConfigTransformer2021090610\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory::TYPE_DEFAULTS);
        return new \ConfigTransformer2021090610\PhpParser\Node\Stmt\Expression($decoratedMethodCall);
    }
    /**
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer2021090610\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $key === \ConfigTransformer2021090610\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_DEFAULTS;
    }
    private function createServicesVariable() : \ConfigTransformer2021090610\PhpParser\Node\Expr\Variable
    {
        return new \ConfigTransformer2021090610\PhpParser\Node\Expr\Variable(\ConfigTransformer2021090610\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
    }
}
