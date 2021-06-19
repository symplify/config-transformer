<?php

declare (strict_types=1);
namespace ConfigTransformer202106193\Symplify\PhpConfigPrinter\NodeTraverser;

use ConfigTransformer202106193\Nette\Utils\Strings;
use ConfigTransformer202106193\PhpParser\BuilderFactory;
use ConfigTransformer202106193\PhpParser\Node;
use ConfigTransformer202106193\PhpParser\Node\Name;
use ConfigTransformer202106193\PhpParser\Node\Stmt\Nop;
use ConfigTransformer202106193\PhpParser\Node\Stmt\Use_;
use ConfigTransformer202106193\PhpParser\NodeTraverser;
use ConfigTransformer202106193\Symplify\PhpConfigPrinter\NodeVisitor\ImportFullyQualifiedNamesNodeVisitor;
final class ImportFullyQualifiedNamesNodeTraverser
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeVisitor\ImportFullyQualifiedNamesNodeVisitor
     */
    private $importFullyQualifiedNamesNodeVisitor;
    /**
     * @var \PhpParser\BuilderFactory
     */
    private $builderFactory;
    public function __construct(\ConfigTransformer202106193\Symplify\PhpConfigPrinter\NodeVisitor\ImportFullyQualifiedNamesNodeVisitor $importFullyQualifiedNamesNodeVisitor, \ConfigTransformer202106193\PhpParser\BuilderFactory $builderFactory)
    {
        $this->importFullyQualifiedNamesNodeVisitor = $importFullyQualifiedNamesNodeVisitor;
        $this->builderFactory = $builderFactory;
    }
    /**
     * @param Node[] $nodes
     * @return Node[]
     */
    public function traverseNodes(array $nodes) : array
    {
        $nameImports = $this->collectNameImportsFromNodes($nodes);
        if ($nameImports === []) {
            return $nodes;
        }
        return $this->addUseImportsToNamespace($nodes, $nameImports);
    }
    /**
     * @param Node[] $nodes
     * @param string[] $nameImports
     * @return Node[]
     */
    private function addUseImportsToNamespace(array $nodes, array $nameImports) : array
    {
        if ($nameImports === []) {
            return $nodes;
        }
        \sort($nameImports);
        $useImports = $this->createUses($nameImports);
        $useImports[] = new \ConfigTransformer202106193\PhpParser\Node\Stmt\Nop();
        return \array_merge($useImports, $nodes);
    }
    /**
     * @param Node[] $nodes
     * @return string[]
     */
    private function collectNameImportsFromNodes(array $nodes) : array
    {
        $nodeTraverser = new \ConfigTransformer202106193\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->importFullyQualifiedNamesNodeVisitor);
        $nodeTraverser->traverse($nodes);
        $nameImports = $this->importFullyQualifiedNamesNodeVisitor->getNameImports();
        return \array_unique($nameImports);
    }
    /**
     * @param string[] $nameImports
     * @return Use_[]
     */
    private function createUses(array $nameImports) : array
    {
        $useImports = [];
        foreach ($nameImports as $nameImport) {
            $shortNameImport = \ConfigTransformer202106193\Nette\Utils\Strings::after($nameImport, '\\', -1);
            if (\function_exists($nameImport) || $shortNameImport === 'ref') {
                $useBuilder = $this->builderFactory->useFunction(new \ConfigTransformer202106193\PhpParser\Node\Name($nameImport));
                /** @var Use_ $use */
                $use = $useBuilder->getNode();
                $useImports[] = $use;
            } else {
                $useBuilder = $this->builderFactory->use(new \ConfigTransformer202106193\PhpParser\Node\Name($nameImport));
                /** @var Use_ $use */
                $use = $useBuilder->getNode();
                $useImports[] = $use;
            }
        }
        return $useImports;
    }
}
