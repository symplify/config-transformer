<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeTraverser;

use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeVisitor\ImportFullyQualifiedNamesNodeVisitor;
use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Nop;
use PhpParser\NodeFinder;
use PhpParser\NodeTraverser;

final class ImportFullyQualifiedNamesNodeTraverser
{
    /**
     * @var ImportFullyQualifiedNamesNodeVisitor
     */
    private $importFullyQualifiedNamesNodeVisitor;

    /**
     * @var NodeFinder
     */
    private $nodeFinder;

    /**
     * @var BuilderFactory
     */
    private $builderFactory;

    public function __construct(
        ImportFullyQualifiedNamesNodeVisitor $importFullyQualifiedNamesNodeVisitor,
        NodeFinder $nodeFinder,
        BuilderFactory $builderFactory
    ) {
        $this->importFullyQualifiedNamesNodeVisitor = $importFullyQualifiedNamesNodeVisitor;
        $this->nodeFinder = $nodeFinder;
        $this->builderFactory = $builderFactory;
    }

    /**
     * @param Node[] $nodes
     * @return Node[]
     */
    public function traverseNodes(array $nodes): array
    {
        $nodeTraverser = new NodeTraverser();
        $nodeTraverser->addVisitor($this->importFullyQualifiedNamesNodeVisitor);

        $nodes = $nodeTraverser->traverse($nodes);

        $nameImports = $this->importFullyQualifiedNamesNodeVisitor->getNameImports();
        $nameImports = array_unique($nameImports);

        if (count($nameImports) === 0) {
            return $nodes;
        }

        $this->addUseImportsToNamespace($nodes, $nameImports);

        return $nodes;
    }

    /**
     * @param Node[] $nodes
     * @param string[] $nameImports
     */
    private function addUseImportsToNamespace(array $nodes, array $nameImports): void
    {
        sort($nameImports);

        /** @var Namespace_ $namespace */
        $namespace = $this->nodeFinder->findFirstInstanceOf($nodes, Namespace_::class);

        $useImports = [];
        foreach ($nameImports as $nameImport) {
            $useBuilder = $this->builderFactory->use(new Name($nameImport));
            $useImports[] = $useBuilder->getNode();
        }

        $useImports[] = new Nop();

        $namespace->stmts = array_merge($useImports, $namespace->stmts);
    }
}
