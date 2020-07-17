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
     * @var BuilderFactory
     */
    private $builderFactory;

    public function __construct(
        ImportFullyQualifiedNamesNodeVisitor $importFullyQualifiedNamesNodeVisitor,
        BuilderFactory $builderFactory
    ) {
        $this->importFullyQualifiedNamesNodeVisitor = $importFullyQualifiedNamesNodeVisitor;
        $this->builderFactory = $builderFactory;
    }

    /**
     * @param Node[] $nodes
     * @return Node[]
     */
    public function traverseNodes(array $nodes): array
    {
        $nameImports = $this->collectNameImportsFromNodes($nodes);
        if (count($nameImports) === 0) {
            return $nodes;
        }

        return $this->addUseImportsToNamespace($nodes, $nameImports);
    }

    /**
     * @param Node[] $nodes
     * @param string[] $nameImports
     * @return Node[]
     */
    private function addUseImportsToNamespace(array $nodes, array $nameImports): array
    {
        sort($nameImports);

        // /** @var Namespace_ $namespace */
//        $namespace = $this->nodeFinder->findFirstInstanceOf($nodes, Namespace_::class);

        $useImports = [];
        foreach ($nameImports as $nameImport) {
            $useBuilder = $this->builderFactory->use(new Name($nameImport));
            $useImports[] = $useBuilder->getNode();
        }

        $useImports[] = new Nop();

        return array_merge($useImports, $nodes);
//        $namespace->stmts = array_merge($useImports, $namespace->stmts);
    }

    /**
     * @param Node[] $nodes
     * @return string[]
     */
    private function collectNameImportsFromNodes(array $nodes): array
    {
        $nodeTraverser = new NodeTraverser();
        $nodeTraverser->addVisitor($this->importFullyQualifiedNamesNodeVisitor);
        $nodeTraverser->traverse($nodes);

        $nameImports = $this->importFullyQualifiedNamesNodeVisitor->getNameImports();
        return array_unique($nameImports);
    }
}
