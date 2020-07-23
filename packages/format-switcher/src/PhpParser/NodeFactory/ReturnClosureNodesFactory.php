<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\CaseConverterInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\KeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\MethodName;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use Migrify\ConfigTransformer\FormatSwitcher\Yaml\YamlCommentPreserver;
use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;

final class ReturnClosureNodesFactory
{
    /**
     * @var ClosureNodeFactory
     */
    private $closureNodeFactory;

    /**
     * @var KeyYamlToPhpFactoryInterface[]
     */
    private $keyYamlToPhpFactories = [];

    /**
     * @var YamlCommentPreserver
     */
    private $yamlCommentPreserver;

    /**
     * @var CaseConverterInterface[]
     */
    private $caseConverters;

    /**
     * @param KeyYamlToPhpFactoryInterface[] $keyYamlToPhpFactories
     * @param CaseConverterInterface[] $caseConverters
     */
    public function __construct(
        ClosureNodeFactory $closureNodeFactory,
        YamlCommentPreserver $yamlCommentPreserver,
        array $keyYamlToPhpFactories,
        array $caseConverters
    ) {
        $this->closureNodeFactory = $closureNodeFactory;
        $this->keyYamlToPhpFactories = $keyYamlToPhpFactories;
        $this->yamlCommentPreserver = $yamlCommentPreserver;
        $this->caseConverters = $caseConverters;
    }

    public function createFromYamlArray(array $yamlArray): Return_
    {
        $yamlArray = $this->yamlCommentPreserver->collectCommentsFromArray($yamlArray);
        $collectedComments = $this->yamlCommentPreserver->getCollectedComments();

        $closureStmts = $this->createClosureStmts($yamlArray);
        $closure = $this->closureNodeFactory->createClosureFromStmts($closureStmts);

        $return = new Return_($closure);
        $this->yamlCommentPreserver->decorateNodeWithComments($return, $collectedComments);

        return $return;
    }

    /**
     * @return Node[]
     */
    private function createClosureStmts(array $yamlData): array
    {
        $yamlData = $this->removeEmptyValues($yamlData);

        // new single-interface approach to handle all cases
        $nodes = $this->createNodesFromCaseConverters($yamlData);

        foreach ($yamlData as $key => $values) {
            if ($this->yamlCommentPreserver->isCommentKey($key)) {
                $this->yamlCommentPreserver->collectComment($values);
                continue;
            }

            foreach ($this->keyYamlToPhpFactories as $keyYamlToPhpFactory) {
                if ($keyYamlToPhpFactory->getKey() !== $key) {
                    continue;
                }

                $freshNodes = $keyYamlToPhpFactory->convertYamlToNodes($values);
                $nodes = array_merge($nodes, $freshNodes);

                $firstNode = $nodes[0];
                $this->yamlCommentPreserver->decorateNodeWithComments($firstNode);

                continue 2;
            }

            throw new ShouldNotHappenException(sprintf('Key "%s" is not supported', $key));
        }

        return $nodes;
    }

    private function removeEmptyValues(array $yamlData): array
    {
        return array_filter($yamlData);
    }

    private function createInitializeAssign(string $variableName, string $methodName): Expression
    {
        $servicesVariable = new Variable($variableName);
        $containerConfiguratorVariable = new Variable(VariableName::CONTAINER_CONFIGURATOR);

        $assign = new Assign($servicesVariable, new MethodCall($containerConfiguratorVariable, $methodName));

        return new Expression($assign);
    }

    /**
     * @param mixed[] $yamlData
     * @return Node[]
     */
    private function createNodesFromCaseConverters(array $yamlData): array
    {
        $nodes = [];

        foreach ($yamlData as $key => $values) {
            if ($key === YamlKey::SERVICES) {
                $nodes[] = $this->createInitializeAssign(VariableName::SERVICES, MethodName::SERVICES);
            }

            foreach ($values as $nestedKey => $nestedValues) {
                foreach ($this->caseConverters as $caseConverter) {
                    if (! $caseConverter->match($key, $nestedKey, $nestedValues)) {
                        continue;
                    }

                    /** @var string $nestedKey */
                    $nodes[] = $caseConverter->convertToMethodCall($nestedKey, $nestedValues);
                }
            }
        }

        return $nodes;
    }
}
