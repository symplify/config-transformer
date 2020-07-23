<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\KeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;
use Migrify\ConfigTransformer\FormatSwitcher\Yaml\YamlCommentPreserver;
use PhpParser\Node;
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
     * @param KeyYamlToPhpFactoryInterface[] $keyYamlToPhpFactories
     */
    public function __construct(
        ClosureNodeFactory $closureNodeFactory,
        YamlCommentPreserver $yamlCommentPreserver,
        array $keyYamlToPhpFactories
    ) {
        $this->closureNodeFactory = $closureNodeFactory;
        $this->keyYamlToPhpFactories = $keyYamlToPhpFactories;
        $this->yamlCommentPreserver = $yamlCommentPreserver;
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
        $nodes = [];

        $yamlData = $this->removeEmptyValues($yamlData);

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
}
