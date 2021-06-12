<?php

declare (strict_types=1);
namespace ConfigTransformer2021061210\Symplify\PhpConfigPrinter\NodeVisitor;

use ConfigTransformer2021061210\Nette\Utils\Strings;
use ConfigTransformer2021061210\PhpParser\Node;
use ConfigTransformer2021061210\PhpParser\Node\Name;
use ConfigTransformer2021061210\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer2021061210\PhpParser\NodeVisitorAbstract;
use ConfigTransformer2021061210\Symplify\PhpConfigPrinter\Naming\ClassNaming;
final class ImportFullyQualifiedNamesNodeVisitor extends \ConfigTransformer2021061210\PhpParser\NodeVisitorAbstract
{
    /**
     * @var string[]
     */
    private $nameImports = [];
    /**
     * @var \Symplify\PhpConfigPrinter\Naming\ClassNaming
     */
    private $classNaming;
    public function __construct(\ConfigTransformer2021061210\Symplify\PhpConfigPrinter\Naming\ClassNaming $classNaming)
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
    public function enterNode(\ConfigTransformer2021061210\PhpParser\Node $node) : ?\ConfigTransformer2021061210\PhpParser\Node
    {
        if (!$node instanceof \ConfigTransformer2021061210\PhpParser\Node\Name\FullyQualified) {
            return null;
        }
        $fullyQualifiedName = $node->toString();
        // namespace-less class name
        if (\ConfigTransformer2021061210\Nette\Utils\Strings::startsWith($fullyQualifiedName, '\\')) {
            $fullyQualifiedName = \ltrim($fullyQualifiedName, '\\');
        }
        if (!\ConfigTransformer2021061210\Nette\Utils\Strings::contains($fullyQualifiedName, '\\')) {
            return new \ConfigTransformer2021061210\PhpParser\Node\Name($fullyQualifiedName);
        }
        $shortClassName = $this->classNaming->getShortName($fullyQualifiedName);
        $this->nameImports[] = $fullyQualifiedName;
        return new \ConfigTransformer2021061210\PhpParser\Node\Name($shortClassName);
    }
    /**
     * @return string[]
     */
    public function getNameImports() : array
    {
        return $this->nameImports;
    }
}
