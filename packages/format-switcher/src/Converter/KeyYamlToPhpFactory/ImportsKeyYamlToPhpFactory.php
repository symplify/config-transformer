<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\KeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Configuration\Configuration;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\KeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\Sorter\YamlArgumentSorter;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use Nette\Utils\Strings;
use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
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
     * @var YamlArgumentSorter
     */
    private $yamlArgumentSorter;

    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(
        YamlArgumentSorter $yamlArgumentSorter,
        CommonNodeFactory $commonNodeFactory,
        Configuration $configuration
    ) {
        $this->yamlArgumentSorter = $yamlArgumentSorter;
        $this->commonNodeFactory = $commonNodeFactory;
        $this->configuration = $configuration;
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
                    [YamlKey::RESOURCE => '', 'type' => null, YamlKey::IGNORE_ERRORS => false]
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

            $expr = $this->resolveExpr($value);
            $args[] = new Arg($expr);
        }

        return $args;
    }

    private function shouldSkipDefaultValue(string $name, $value, array $arguments): bool
    {
        // skip default value for "ignore_errors"
        if ($name === YamlKey::IGNORE_ERRORS && $value === false) {
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
        return isset($arguments[YamlKey::IGNORE_ERRORS]) && $arguments[YamlKey::IGNORE_ERRORS] === false;
    }

    private function replaceImportedFileSuffix($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        $inputSuffixRegex = '#\.' . preg_quote($this->configuration->getInputFormat(), '#') . '$#';

        return Strings::replace($value, $inputSuffixRegex, '.' . $this->configuration->getOutputFormat());
    }

    private function resolveExpr($value): Expr
    {
        if (is_bool($value) || in_array($value, ['annotations', 'directory', 'glob'], true)) {
            return BuilderHelpers::normalizeValue($value);
        }

        if ($value === 'not_found') {
            return new Node\Scalar\String_('not_found');
        }

        $value = $this->replaceImportedFileSuffix($value);
        return $this->commonNodeFactory->createAbsoluteDirExpr($value);
    }
}
