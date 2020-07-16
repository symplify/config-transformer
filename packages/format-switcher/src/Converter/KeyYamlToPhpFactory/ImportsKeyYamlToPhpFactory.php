<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\KeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\KeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\Sorter\YamlArgumentSorter;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

/**
 * Handles this part:
 *
 * imports: <---
 */
final class ImportsKeyYamlToPhpFactory implements KeyYamlToPhpFactoryInterface
{
    /**
     * @var string
     */
    private const IGNORE_ERRORS = 'ignore_errors';

    /**
     * @var YamlArgumentSorter
     */
    private $yamlArgumentSorter;

    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    public function __construct(YamlArgumentSorter $yamlArgumentSorter, CommonNodeFactory $commonNodeFactory)
    {
        $this->yamlArgumentSorter = $yamlArgumentSorter;
        $this->commonNodeFactory = $commonNodeFactory;
    }

    public function getKey(): string
    {
        return YamlKey::IMPORTS;
    }

    /**
     * @param mixed[] $yaml
     * @return Node[]
     */
    public function convertYamlToNodes(array $yaml): array
    {
        $nodes = [];

        foreach ($yaml as $import) {
            if (is_array($import)) {
                $arguments = $this->yamlArgumentSorter->sortArgumentsByKeyIfExists(
                    $import,
                    [YamlKey::RESOURCE => '', 'type' => null, self::IGNORE_ERRORS => false]
                );

                $nodes[] = $this->createImportMethodCall($arguments);
                continue;
            }

            throw new NotImplementedYetException();
        }

        return $nodes;
    }

    /**
     * @param mixed[] $arguments
     */
    private function createImportMethodCall(array $arguments): Expression
    {
        $containerConfiguratorVariable = new Variable(VariableName::CONTAINER_CONFIGURATOR);

        $args = $this->createArgs($arguments);
        $methodCall = new MethodCall($containerConfiguratorVariable, 'import', $args);

        return new Expression($methodCall);
    }

    /**
     * @param mixed[] $arguments
     * @return Arg[]
     */
    private function createArgs(array $arguments): array
    {
        $args = [];
        foreach ($arguments as $name => $value) {
            if ($this->shouldSkipDefaultValue($name, $value, $arguments)) {
                continue;
            }

            if (is_bool($value) || in_array($value, ['annotations', 'directory', 'glob'], true)) {
                $expr = BuilderHelpers::normalizeValue($value);
            } else {
                $expr = $this->commonNodeFactory->createAbsoluteDirExpr($value);
            }

            $args[] = new Arg($expr);
        }

        return $args;
    }

    private function shouldSkipDefaultValue(string $name, $value, array $arguments): bool
    {
        // skip default value for "ignore_errors"
        if ($name === self::IGNORE_ERRORS && $value === false) {
            return true;
        }

        // check if default value for "type"
        if ($name !== 'type') {
            return false;
        }

        if ($value !== null) {
            return false;
        }

        // follow by default value for "ignore_errors"
        return isset($arguments[self::IGNORE_ERRORS]) && $arguments[self::IGNORE_ERRORS] === false;
    }
}
