<?php

declare (strict_types=1);
namespace ConfigTransformer202106129\Symplify\PhpConfigPrinter\NodeVisitor;

use ConfigTransformer202106129\Nette\Utils\Strings;
use ConfigTransformer202106129\PhpParser\Node;
use ConfigTransformer202106129\PhpParser\Node\Name;
use ConfigTransformer202106129\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202106129\PhpParser\NodeVisitorAbstract;
use ConfigTransformer202106129\Symplify\PhpConfigPrinter\Naming\ClassNaming;
final class ImportFullyQualifiedNamesNodeVisitor extends \ConfigTransformer202106129\PhpParser\NodeVisitorAbstract
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var string[]
     */
    private $nameImports = [];
    public function __construct(\ConfigTransformer202106129\Symplify\PhpConfigPrinter\Naming\ClassNaming $classNaming)
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
    public function enterNode(\ConfigTransformer202106129\PhpParser\Node $node) : ?\ConfigTransformer202106129\PhpParser\Node
    {
        if (!$node instanceof \ConfigTransformer202106129\PhpParser\Node\Name\FullyQualified) {
            return null;
        }
        $fullyQualifiedName = $node->toString();
        // namespace-less class name
        if (\ConfigTransformer202106129\Nette\Utils\Strings::startsWith($fullyQualifiedName, '\\')) {
            $fullyQualifiedName = \ltrim($fullyQualifiedName, '\\');
        }
        if (!\ConfigTransformer202106129\Nette\Utils\Strings::contains($fullyQualifiedName, '\\')) {
            return new \ConfigTransformer202106129\PhpParser\Node\Name($fullyQualifiedName);
        }
        $shortClassName = $this->classNaming->getShortName($fullyQualifiedName);
        $this->nameImports[] = $fullyQualifiedName;
        return new \ConfigTransformer202106129\PhpParser\Node\Name($shortClassName);
    }
    /**
     * @return string[]
     */
    public function getNameImports() : array
    {
        return $this->nameImports;
    }
}
