<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\CaseConverter;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\CaseConverterInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\MethodName;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

/**
 * Handles this part:
 *
 * framework: <---
 *     key: value
 */
final class ExtensionConverter implements CaseConverterInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var string
     */
    private $rootKey;

    /**
     * @var YamlKey
     */
    private $yamlKey;

    public function __construct(ArgsNodeFactory $argsNodeFactory, YamlKey $yamlKey)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->yamlKey = $yamlKey;
    }

    public function convertToMethodCall($key, $values): Expression
    {
        $args = $this->argsNodeFactory->createFromValues([
            $this->rootKey,
            [$key => $values],
        ]);

        $containerConfiguratorVariable = new Variable(VariableName::CONTAINER_CONFIGURATOR);
        $methodCall = new MethodCall($containerConfiguratorVariable, MethodName::EXTENSION, $args);

        return new Expression($methodCall);
    }

    public function match(string $rootKey, $key, $values): bool
    {
        $this->rootKey = $rootKey;

        return ! in_array($rootKey, $this->yamlKey->provideRootKeys(), true);
    }
}
