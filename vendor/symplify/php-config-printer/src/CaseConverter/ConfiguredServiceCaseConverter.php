<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer2022052210\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2022052210\PhpParser\Node\Expr\Variable;
use ConfigTransformer2022052210\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2022052210\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer2022052210\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2022052210\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ConfiguredServiceCaseConverter implements \ConfigTransformer2022052210\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\ConfigTransformer2022052210\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer2022052210\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer2022052210\PhpParser\Node\Stmt\Expression
    {
        $valuesForArgs = [$key];
        if (isset($values[\ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY])) {
            $valuesForArgs[] = $values[\ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::CLASS_KEY];
        }
        $args = $this->argsNodeFactory->createFromValues($valuesForArgs);
        $methodCall = new \ConfigTransformer2022052210\PhpParser\Node\Expr\MethodCall(new \ConfigTransformer2022052210\PhpParser\Node\Expr\Variable(\ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), \ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\MethodName::SET, $args);
        $decoratedMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $methodCall);
        return new \ConfigTransformer2022052210\PhpParser\Node\Stmt\Expression($decoratedMethodCall);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if ($key === \ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_DEFAULTS) {
            return \false;
        }
        if ($key === \ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_INSTANCEOF) {
            return \false;
        }
        if (isset($values[\ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::RESOURCE])) {
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
        if (isset($values[\ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::ALIAS])) {
            return \true;
        }
        if (!\is_string($values)) {
            return \false;
        }
        return \strncmp($values, '@', \strlen('@')) === 0;
    }
}
