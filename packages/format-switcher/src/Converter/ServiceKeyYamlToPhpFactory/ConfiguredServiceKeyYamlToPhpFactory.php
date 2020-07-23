<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\ServiceKeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\ServiceOptionNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\MethodName;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use Nette\Utils\Strings;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

/**
 * Handles this part:
 *
 * services:
 *     SomeNamespace\SomeClass: null <---
 */
final class ConfiguredServiceKeyYamlToPhpFactory implements ServiceKeyYamlToPhpFactoryInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;

    public function __construct(ArgsNodeFactory $argsNodeFactory, ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }

    public function convertYamlToNode($key, $yaml): Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$key]);
        $methodCall = new MethodCall(new Variable(VariableName::SERVICES), MethodName::SET, $args);

        $methodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($yaml, $methodCall);

        $expression = new Expression($methodCall);
        $expression->setAttribute('comments', $methodCall->getComments());
        return $expression;
    }

    public function isMatch($key, $values): bool
    {
        if ($key === YamlKey::_DEFAULTS) {
            return false;
        }

        if ($key === YamlKey::_INSTANCEOF) {
            return false;
        }

        if (isset($values[YamlKey::RESOURCE])) {
            return false;
        }

        // handled by @see \Migrify\ConfigTransformer\FormatSwitcher\Converter\CaseConverter\AliasCaseConverter
        if ($this->isAlias($values)) {
            return false;
        }

        if ($values === null) {
            return false;
        }

        return $values !== [];
    }

    private function isAlias($values): bool
    {
        if (isset($values[YamlKey::ALIAS])) {
            return true;
        }

        return is_string($values) && Strings::startsWith($values, '@');
    }
}
