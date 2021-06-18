<?php

declare (strict_types=1);
namespace ConfigTransformer2021061810\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021061810\PhpParser\Node\Expr\Variable;
use ConfigTransformer2021061810\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2021061810\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer2021061810\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2021061810\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ClassServiceCaseConverter implements \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\ConfigTransformer2021061810\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021061810\PhpParser\Node\Stmt\Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$key, $values[\ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY]]);
        $setMethodCall = new \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall(new \ConfigTransformer2021061810\PhpParser\Node\Expr\Variable(\ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\MethodName::SET, $args);
        unset($values[\ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY]);
        $setMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $setMethodCall);
        return new \ConfigTransformer2021061810\PhpParser\Node\Stmt\Expression($setMethodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (\is_array($values) && \count($values) !== 1) {
            return \false;
        }
        if (!isset($values[\ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY])) {
            return \false;
        }
        return !isset($values[\ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::ALIAS]);
    }
}
