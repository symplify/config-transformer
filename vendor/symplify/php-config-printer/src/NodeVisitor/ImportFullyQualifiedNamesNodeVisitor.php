<?php

declare (strict_types=1);
namespace ConfigTransformer202106183\Symplify\PhpConfigPrinter\NodeVisitor;

use ConfigTransformer202106183\PhpParser\Node;
use ConfigTransformer202106183\PhpParser\Node\Name;
use ConfigTransformer202106183\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202106183\PhpParser\NodeVisitorAbstract;
use ConfigTransformer202106183\Symplify\PhpConfigPrinter\Naming\ClassNaming;
final class ImportFullyQualifiedNamesNodeVisitor extends \ConfigTransformer202106183\PhpParser\NodeVisitorAbstract
{
    /**
     * @var string[]
     */
    private $nameImports = [];
    /**
     * @var \Symplify\PhpConfigPrinter\Naming\ClassNaming
     */
    private $classNaming;
    public function __construct(\ConfigTransformer202106183\Symplify\PhpConfigPrinter\Naming\ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }
    /**
     * @param Node[] $nodes
     * @return Node[]|null
     */
    public function beforeTraverse(array $nodes) : ?array
    {
        $this->nameImports = [];
        return null;
    }
    public function enterNode(\ConfigTransformer202106183\PhpParser\Node $node) : ?\ConfigTransformer202106183\PhpParser\Node
    {
        if (!$node instanceof \ConfigTransformer202106183\PhpParser\Node\Name\FullyQualified) {
            return null;
        }
        $fullyQualifiedName = $node->toString();
        if (\strncmp($fullyQualifiedName, '\\', \strlen('\\')) === 0) {
            $fullyQualifiedName = \ltrim($fullyQualifiedName, '\\');
        }
        if (\strpos($fullyQualifiedName, '\\') === \false) {
            return new \ConfigTransformer202106183\PhpParser\Node\Name($fullyQualifiedName);
        }
        $shortClassName = $this->classNaming->getShortName($fullyQualifiedName);
        $this->nameImports[] = $fullyQualifiedName;
        return new \ConfigTransformer202106183\PhpParser\Node\Name($shortClassName);
    }
    /**
     * @return string[]
     */
    public function getNameImports() : array
    {
        return $this->nameImports;
    }
}
