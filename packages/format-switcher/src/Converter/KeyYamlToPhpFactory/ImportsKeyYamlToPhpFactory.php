<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\KeyYamlToPhpFactory;

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
    private const IMPORTS = 'imports';

    /**
     * @var string
     */
    private const RESOURCE = 'resource';

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
        return self::IMPORTS;
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
                    [self::RESOURCE, 'type', 'ignore_errors']
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
        $methodCall = new MethodCall($containerConfiguratorVariable, 'import');

        foreach ($arguments as $argument) {
            if (is_bool($argument) || in_array($argument, ['annotations', 'directory', 'glob'], true)) {
                $expr = BuilderHelpers::normalizeValue($argument);
            } else {
                $expr = $this->commonNodeFactory->createAbsoluteDirExpr($argument);
            }

            $methodCall->args[] = new Arg($expr);
        }

        return new Expression($methodCall);
    }
}
