<?php

declare (strict_types=1);
namespace ConfigTransformer202203063\Symplify\PhpConfigPrinter\NodeTraverser;

use ConfigTransformer202203063\PhpParser\BuilderFactory;
use ConfigTransformer202203063\PhpParser\Node;
use ConfigTransformer202203063\PhpParser\Node\Name;
use ConfigTransformer202203063\PhpParser\Node\Stmt\Nop;
use ConfigTransformer202203063\PhpParser\Node\Stmt\Use_;
use ConfigTransformer202203063\PhpParser\NodeTraverser;
use ConfigTransformer202203063\PhpParser\NodeVisitor\ParentConnectingVisitor;
use ConfigTransformer202203063\Symplify\PhpConfigPrinter\NodeVisitor\ImportFullyQualifiedNamesNodeVisitor;
use ConfigTransformer202203063\Symplify\PhpConfigPrinter\Sorter\FullyQualifiedImportSorter;
use ConfigTransformer202203063\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport;
use ConfigTransformer202203063\Symplify\PhpConfigPrinter\ValueObject\ImportType;
final class ImportFullyQualifiedNamesNodeTraverser
{
    /**
     * @var \PhpParser\NodeVisitor\ParentConnectingVisitor
     */
    private $parentConnectingVisitor;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeVisitor\ImportFullyQualifiedNamesNodeVisitor
     */
    private $importFullyQualifiedNamesNodeVisitor;
    /**
     * @var \Symplify\PhpConfigPrinter\Sorter\FullyQualifiedImportSorter
     */
    private $fullyQualifiedImportSorter;
    /**
     * @var \PhpParser\BuilderFactory
     */
    private $builderFactory;
    public function __construct(\ConfigTransformer202203063\PhpParser\NodeVisitor\ParentConnectingVisitor $parentConnectingVisitor, \ConfigTransformer202203063\Symplify\PhpConfigPrinter\NodeVisitor\ImportFullyQualifiedNamesNodeVisitor $importFullyQualifiedNamesNodeVisitor, \ConfigTransformer202203063\Symplify\PhpConfigPrinter\Sorter\FullyQualifiedImportSorter $fullyQualifiedImportSorter, \ConfigTransformer202203063\PhpParser\BuilderFactory $builderFactory)
    {
        $this->parentConnectingVisitor = $parentConnectingVisitor;
        $this->importFullyQualifiedNamesNodeVisitor = $importFullyQualifiedNamesNodeVisitor;
        $this->fullyQualifiedImportSorter = $fullyQualifiedImportSorter;
        $this->builderFactory = $builderFactory;
    }
    /**
     * @param Node[] $nodes
     * @return Node[]
     */
    public function traverseNodes(array $nodes) : array
    {
        $this->collectNameImportsFromNodes($nodes);
        $imports = \array_unique($this->importFullyQualifiedNamesNodeVisitor->getImports());
        return $this->addUseImportsToNamespace($nodes, $imports);
    }
    /**
     * @param Node[] $nodes
     * @param FullyQualifiedImport[] $imports
     * @return Node[]
     */
    private function addUseImportsToNamespace(array $nodes, array $imports) : array
    {
        if ($imports === []) {
            return $nodes;
        }
        $imports = $this->fullyQualifiedImportSorter->sortImports($imports);
        $useImports = $this->createUses($imports);
        return \array_merge($useImports, [new \ConfigTransformer202203063\PhpParser\Node\Stmt\Nop()], $nodes);
    }
    /**
     * @param Node[] $nodes
     */
    private function collectNameImportsFromNodes(array $nodes) : void
    {
        $nodeTraverser = new \ConfigTransformer202203063\PhpParser\NodeTraverser();
        $nodeTraverser->addVisitor($this->parentConnectingVisitor);
        $nodeTraverser->addVisitor($this->importFullyQualifiedNamesNodeVisitor);
        $nodeTraverser->traverse($nodes);
    }
    /**
     * @param FullyQualifiedImport[] $imports
     * @return Use_[]
     */
    private function createUses(array $imports) : array
    {
        $useImports = [];
        foreach ($imports as $import) {
            $name = new \ConfigTransformer202203063\PhpParser\Node\Name($import->getFullyQualified());
            switch ($import->getType()) {
                case \ConfigTransformer202203063\Symplify\PhpConfigPrinter\ValueObject\ImportType::FUNCTION_TYPE:
                    $useBuilder = $this->builderFactory->useFunction($name);
                    break;
                case \ConfigTransformer202203063\Symplify\PhpConfigPrinter\ValueObject\ImportType::CONSTANT_TYPE:
                    $useBuilder = $this->builderFactory->useConst($name);
                    break;
                default:
                    $useBuilder = $this->builderFactory->use($name);
                    break;
            }
            $useImports[] = $useBuilder->getNode();
        }
        return $useImports;
    }
}
