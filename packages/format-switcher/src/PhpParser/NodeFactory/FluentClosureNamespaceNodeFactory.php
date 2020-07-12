<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\KeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Return_;

final class FluentClosureNamespaceNodeFactory
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
     * @param KeyYamlToPhpFactoryInterface[] $keyYamlToPhpFactories
     */
    public function __construct(ClosureNodeFactory $closureNodeFactory, array $keyYamlToPhpFactories)
    {
        $this->closureNodeFactory = $closureNodeFactory;
        $this->keyYamlToPhpFactories = $keyYamlToPhpFactories;
    }

    public function createFromYamlArray(array $yamlArray): Namespace_
    {
        $closureStmts = $this->createClosureStmts($yamlArray);
        $closure = $this->closureNodeFactory->createClosureFromStmts($closureStmts);

        $namespace = $this->createNamespace();
        $namespace->stmts[] = new Return_($closure);

        return $namespace;
    }

    /**
     * @return Node[]
     */
    private function createClosureStmts(array $yamlData): array
    {
        $nodes = [];

        foreach ($yamlData as $key => $values) {
            // normalize values
            if ($values === null) {
                $values = [];
            }

            foreach ($this->keyYamlToPhpFactories as $keyYamlToPhpFactory) {
                if ($keyYamlToPhpFactory->getKey() !== $key) {
                    continue;
                }

                $freshNodes = $keyYamlToPhpFactory->convertYamlToNodes($values);
                $nodes = array_merge($nodes, $freshNodes);
                continue 2;
            }

            throw new ShouldNotHappenException(sprintf('Key "%s" is not supported', $key));
        }

        return $nodes;
    }

    private function createNamespace(): Namespace_
    {
        $namespaceName = new Name('Symfony\Component\DependencyInjection\Loader\Configurator');
        return new Namespace_($namespaceName);
    }
}
