<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\CaseConverterInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\NestedCaseConverterInterface;
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
     * @var YamlCommentPreserver
     */
    private $yamlCommentPreserver;

    /**
     * @var CaseConverterInterface[]
     */
    private $caseConverters = [];

    /**
     * @var NestedCaseConverterInterface[]
     */
    private $nestedCaseConverters = [];

    /**
     * @param CaseConverterInterface[] $caseConverters
     * @param NestedCaseConverterInterface[] $nestedCaseConverters
     */
    public function __construct(
        ClosureNodeFactory $closureNodeFactory,
        YamlCommentPreserver $yamlCommentPreserver,
        array $caseConverters,
        array $nestedCaseConverters
    ) {
        $this->closureNodeFactory = $closureNodeFactory;
        $this->yamlCommentPreserver = $yamlCommentPreserver;
        $this->caseConverters = $caseConverters;
        $this->nestedCaseConverters = $nestedCaseConverters;
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

        return $this->createNodesFromCaseConverters($yamlData);
    }

    private function removeEmptyValues(array $yamlData): array
    {
        return array_filter($yamlData);
    }

    /**
     * @param mixed[] $yamlData
     * @return Node[]
     */
    private function createNodesFromCaseConverters(array $yamlData): array
    {
        $nodes = [];

        foreach ($yamlData as $key => $values) {
            $nodes = $this->createInitializeNode($key, $nodes);

            foreach ($values as $nestedKey => $nestedValues) {
                $expression = null;

                $nestedNodes = [];
                if (is_array($nestedValues)) {
                    foreach ($nestedValues as $subNestedKey => $subNestedValue) {
                        if ($this->yamlCommentPreserver->isCommentKey($subNestedKey)) {
                            $this->yamlCommentPreserver->collectComment($subNestedValue);
                            continue;
                        }

                        foreach ($this->nestedCaseConverters as $nestedCaseConverter) {
                            if (! $nestedCaseConverter->match($key, $nestedKey)) {
                                continue;
                            }

                            $expression = $nestedCaseConverter->convertToMethodCall($subNestedKey, $subNestedValue);
                            $nestedNodes[] = $expression;
                        }
                    }
                }

                if ($nestedNodes !== []) {
                    $nodes = array_merge($nodes, $nestedNodes);
                    continue;
                }

                foreach ($this->caseConverters as $caseConverter) {
                    if (! $caseConverter->match($key, $nestedKey, $nestedValues)) {
                        continue;
                    }

                    if ($this->yamlCommentPreserver->isCommentKey($nestedKey)) {
                        $this->yamlCommentPreserver->collectComment($nestedValues);
                        continue;
                    }

                    /** @var string $nestedKey */
                    $expression = $caseConverter->convertToMethodCall($nestedKey, $nestedValues);
                    break;
                }

                if ($expression === null) {
                    continue;
                }

                $this->yamlCommentPreserver->decorateNodeWithComments($expression);
                $nodes[] = $expression;
            }
        }

        return $nodes;
    }

    private function createInitializeAssign(string $variableName, string $methodName): Expression
    {
        $servicesVariable = new Variable($variableName);
        $containerConfiguratorVariable = new Variable(VariableName::CONTAINER_CONFIGURATOR);

        $assign = new Assign($servicesVariable, new MethodCall($containerConfiguratorVariable, $methodName));

        return new Expression($assign);
    }

    private function createInitializeNode(string $key, array $nodes): array
    {
        if ($key === YamlKey::SERVICES) {
            $nodes[] = $this->createInitializeAssign(VariableName::SERVICES, MethodName::SERVICES);
        }

        if ($key === YamlKey::PARAMETERS) {
            $nodes[] = $this->createInitializeAssign(VariableName::PARAMETERS, MethodName::PARAMETERS);
        }

        return $nodes;
    }
}
