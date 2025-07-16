<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformerPrefix202507\PhpParser\Node\Expr\MethodCall;
use ConfigTransformerPrefix202507\PhpParser\Node\Expr\Variable;
use ConfigTransformerPrefix202507\PhpParser\Node\Stmt;
use ConfigTransformerPrefix202507\PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\MethodName;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ConfiguredServiceCaseConverter implements CaseConverterInterface
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(ArgsNodeFactory $argsNodeFactory, ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCallStmt($key, $values) : Stmt
    {
        $valuesForArgs = [$key];
        if (isset($values[YamlKey::CLASS_KEY])) {
            $valuesForArgs[] = $values[YamlKey::CLASS_KEY];
        }
        $args = $this->argsNodeFactory->createFromValues($valuesForArgs);
        $methodCall = new MethodCall(new Variable(VariableName::SERVICES), MethodName::SET, $args);
        $decoratedMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $methodCall);
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
        if ($key === YamlKey::_DEFAULTS) {
            return \false;
        }
        if ($key === YamlKey::_INSTANCEOF) {
            return \false;
        }
        if (isset($values[YamlKey::RESOURCE])) {
            return \false;
        }
        // handled by @see \Symplify\PhpConfigPrinter\CaseConverter\CaseConverter\AliasCaseConverter
        if ($this->isAlias($values)) {
            return \false;
        }
        if ($values === null) {
            return \false;
        }
        if (\array_key_exists('configure', $values)) {
            return \true;
        }
        return $values !== [];
    }
    /**
     * @param mixed $values
     */
    private function isAlias($values) : bool
    {
        if (isset($values[YamlKey::ALIAS])) {
            return \true;
        }
        if (!\is_string($values)) {
            return \false;
        }
        return \strncmp($values, '@', \strlen('@')) === 0;
    }
}
