<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeVisitor;

use ConfigTransformerPrefix202302\PhpParser\Node;
use ConfigTransformerPrefix202302\PhpParser\Node\Expr\FuncCall;
use ConfigTransformerPrefix202302\PhpParser\Node\Name;
use ConfigTransformerPrefix202302\PhpParser\Node\Name\FullyQualified;
use ConfigTransformerPrefix202302\PhpParser\NodeVisitorAbstract;
use Symplify\PhpConfigPrinter\Naming\ClassNaming;
use Symplify\PhpConfigPrinter\ValueObject\AttributeKey;
use Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport;
use Symplify\PhpConfigPrinter\ValueObject\ImportType;
final class ImportFullyQualifiedNamesNodeVisitor extends NodeVisitorAbstract
{
    /**
     * @var FullyQualifiedImport[]
     */
    private $fullyQualifiedImports = [];
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\Naming\ClassNaming
     */
    private $classNaming;
    public function __construct(ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }
    /**
     * @param Node[] $nodes
     * @return Node[]|null
     */
    public function beforeTraverse(array $nodes) : ?array
    {
        $this->fullyQualifiedImports = [];
        return null;
    }
    public function enterNode(Node $node) : ?Node
    {
        if (!$node instanceof FullyQualified) {
            return null;
        }
        $parent = $node->getAttribute(AttributeKey::PARENT);
        $fullyQualifiedName = $node->toString();
        if (\strncmp($fullyQualifiedName, '\\', \strlen('\\')) === 0) {
            $fullyQualifiedName = \ltrim($fullyQualifiedName, '\\');
        }
        if (\strpos($fullyQualifiedName, '\\') === \false) {
            return new Name($fullyQualifiedName);
        }
        $shortClassName = $this->classNaming->getShortName($fullyQualifiedName);
        // the short class name is already imported - avoid collision of 2 same shorts
        if ($this->isFullyQualifiedImportsWithDifferentShortClassName($fullyQualifiedName)) {
            return null;
        }
        $type = $parent instanceof FuncCall ? ImportType::FUNCTION_TYPE : ImportType::CLASS_TYPE;
        $this->fullyQualifiedImports[] = new FullyQualifiedImport($type, $fullyQualifiedName, $shortClassName);
        return new Name($shortClassName);
    }
    /**
     * @return FullyQualifiedImport[]
     */
    public function getFullyQualifiedImports() : array
    {
        // use unique items here, to provide every import only once and avoid duplicated uses
        return \array_unique($this->fullyQualifiedImports);
    }
    private function isFullyQualifiedImportsWithDifferentShortClassName(string $desiredFullyQualifiedName) : bool
    {
        $desiredShortClassName = $this->classNaming->getShortName($desiredFullyQualifiedName);
        foreach ($this->fullyQualifiedImports as $fullyQualifiedImport) {
            if ($fullyQualifiedImport->getShortClassName() !== $desiredShortClassName) {
                continue;
            }
            if ($desiredFullyQualifiedName !== $fullyQualifiedImport->getFullyQualified()) {
                return \true;
            }
        }
        return \false;
    }
}
