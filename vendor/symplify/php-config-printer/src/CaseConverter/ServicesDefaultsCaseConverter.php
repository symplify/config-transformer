<?php

declare (strict_types=1);
namespace ConfigTransformer2021061210\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer2021061210\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021061210\PhpParser\Node\Expr\Variable;
use ConfigTransformer2021061210\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2021061210\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer2021061210\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory;
use ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ServicesDefaultsCaseConverter implements \ConfigTransformer2021061210\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var AutoBindNodeFactory
     */
    private $autoBindNodeFactory;
    public function __construct(\ConfigTransformer2021061210\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021061210\PhpParser\Node\Stmt\Expression
    {
        $methodCall = new \ConfigTransformer2021061210\PhpParser\Node\Expr\MethodCall($this->createServicesVariable(), \ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ValueObject\MethodName::DEFAULTS);
        $methodCall = $this->autoBindNodeFactory->createAutoBindCalls($values, $methodCall, \ConfigTransformer2021061210\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory::TYPE_DEFAULTS);
        return new \ConfigTransformer2021061210\PhpParser\Node\Stmt\Expression($methodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $key === \ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_DEFAULTS;
    }
    private function createServicesVariable() : \ConfigTransformer2021061210\PhpParser\Node\Expr\Variable
    {
        return new \ConfigTransformer2021061210\PhpParser\Node\Expr\Variable(\ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
    }
}
