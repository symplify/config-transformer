<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeTraverser;

use ConfigTransformerPrefix202507\PhpParser\BuilderFactory;
use ConfigTransformerPrefix202507\PhpParser\Node;
use ConfigTransformerPrefix202507\PhpParser\Node\Name;
use ConfigTransformerPrefix202507\PhpParser\Node\Stmt\Nop;
use ConfigTransformerPrefix202507\PhpParser\Node\Stmt\Use_;
use ConfigTransformerPrefix202507\PhpParser\NodeTraverser;
use ConfigTransformerPrefix202507\PhpParser\NodeVisitor\ParentConnectingVisitor;
use Symplify\PhpConfigPrinter\NodeVisitor\ImportFullyQualifiedNamesNodeVisitor;
use Symplify\PhpConfigPrinter\Sorter\FullyQualifiedImportSorter;
use Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport;
use Symplify\PhpConfigPrinter\ValueObject\ImportType;
final class ImportFullyQualifiedNamesNodeTraverser
{
    /**
     * @readonly
     * @var \PhpParser\NodeVisitor\ParentConnectingVisitor
     */
    private $parentConnectingVisitor;
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeVisitor\ImportFullyQualifiedNamesNodeVisitor
     */
    private $importFullyQualifiedNamesNodeVisitor;
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\Sorter\FullyQualifiedImportSorter
     */
    private $fullyQualifiedImportSorter;
    /**
     * @readonly
     * @var \PhpParser\BuilderFactory
     */
    private $builderFactory;
    public function __construct(ParentConnectingVisitor $parentConnectingVisitor, ImportFullyQualifiedNamesNodeVisitor $importFullyQualifiedNamesNodeVisitor, FullyQualifiedImportSorter $fullyQualifiedImportSorter, BuilderFactory $builderFactory)
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
        $imports = $this->importFullyQualifiedNamesNodeVisitor->getFullyQualifiedImports();
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
        return \array_merge($useImports, [new Nop()], $nodes);
    }
    /**
     * @param Node[] $nodes
     */
    private function collectNameImportsFromNodes(array $nodes) : void
    {
        $nodeTraverser = new NodeTraverser();
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
            $name = new Name($import->getFullyQualified());
            switch ($import->getType()) {
                case ImportType::FUNCTION_TYPE:
                    $useBuilder = $this->builderFactory->useFunction($name);
                    break;
                case ImportType::CONSTANT_TYPE:
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
