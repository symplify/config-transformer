<?php

declare (strict_types=1);
namespace ConfigTransformer2022022110\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer2022022110\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2022022110\PhpParser\Node\Expr\Variable;
use ConfigTransformer2022022110\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2022022110\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer2022022110\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory;
use ConfigTransformer2022022110\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer2022022110\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer2022022110\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ServicesDefaultsCaseConverter implements \ConfigTransformer2022022110\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory
     */
    private $autoBindNodeFactory;
    public function __construct(\ConfigTransformer2022022110\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer2022022110\PhpParser\Node\Stmt\Expression
    {
        $methodCall = new \ConfigTransformer2022022110\PhpParser\Node\Expr\MethodCall($this->createServicesVariable(), \ConfigTransformer2022022110\Symplify\PhpConfigPrinter\ValueObject\MethodName::DEFAULTS);
        $decoratedMethodCall = $this->autoBindNodeFactory->createAutoBindCalls($values, $methodCall, \ConfigTransformer2022022110\Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory::TYPE_DEFAULTS);
        return new \ConfigTransformer2022022110\PhpParser\Node\Stmt\Expression($decoratedMethodCall);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer2022022110\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $key === \ConfigTransformer2022022110\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_DEFAULTS;
    }
    private function createServicesVariable() : \ConfigTransformer2022022110\PhpParser\Node\Expr\Variable
    {
        return new \ConfigTransformer2022022110\PhpParser\Node\Expr\Variable(\ConfigTransformer2022022110\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
    }
}
