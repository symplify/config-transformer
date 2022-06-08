<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer20220608\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer20220608\PhpParser\Node\Expr\Variable;
use ConfigTransformer20220608\PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\MethodName;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ServicesDefaultsCaseConverter implements CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\AutoBindNodeFactory
     */
    private $autoBindNodeFactory;
    public function __construct(AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : Expression
    {
        $methodCall = new MethodCall($this->createServicesVariable(), MethodName::DEFAULTS);
        $decoratedMethodCall = $this->autoBindNodeFactory->createAutoBindCalls($values, $methodCall, AutoBindNodeFactory::TYPE_DEFAULTS);
        return new Expression($decoratedMethodCall);
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
        return $key === YamlKey::_DEFAULTS;
    }
    private function createServicesVariable() : Variable
    {
        return new Variable(VariableName::SERVICES);
    }
}
