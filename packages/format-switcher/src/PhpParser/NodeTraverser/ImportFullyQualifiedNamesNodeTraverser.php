<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeTraverser;

use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeVisitor\ImportFullyQualifiedNamesNodeVisitor;
use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Nop;
use PhpParser\Node\Stmt\Use_;
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
        if (count($nameImports) === 0) {
            return $nodes;
        }

        sort($nameImports);

        $useImports = $this->createUses($nameImports);
        $useImports[] = new Nop();

        return array_merge($useImports, $nodes);
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

    /**
     * @param string[] $nameImports
     * @return Use_[]
     */
    private function createUses(array $nameImports): array
    {
        $useImports = [];
        foreach ($nameImports as $nameImport) {
            $useBuilder = $this->builderFactory->use(new Name($nameImport));
            $useImports[] = $useBuilder->getNode();
        }

        return $useImports;
    }
}
