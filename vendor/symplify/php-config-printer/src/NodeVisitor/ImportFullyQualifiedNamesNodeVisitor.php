<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeVisitor;

use ConfigTransformer20220612\PhpParser\Node;
use ConfigTransformer20220612\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer20220612\PhpParser\Node\Name;
use ConfigTransformer20220612\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer20220612\PhpParser\NodeVisitorAbstract;
use Symplify\PhpConfigPrinter\Naming\ClassNaming;
use Symplify\PhpConfigPrinter\ValueObject\AttributeKey;
use Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport;
use Symplify\PhpConfigPrinter\ValueObject\ImportType;
final class ImportFullyQualifiedNamesNodeVisitor extends NodeVisitorAbstract
{
    /**
     * @var FullyQualifiedImport[]
     */
    private $imports = [];
    /**
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
        $this->imports = [];
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
        if ($parent instanceof FuncCall) {
            $import = new FullyQualifiedImport(ImportType::FUNCTION_TYPE, $fullyQualifiedName);
        } else {
            $import = new FullyQualifiedImport(ImportType::CLASS_TYPE, $fullyQualifiedName);
        }
        $this->imports[] = $import;
        return new Name($shortClassName);
    }
    /**
     * @return FullyQualifiedImport[]
     */
    public function getImports() : array
    {
        return $this->imports;
    }
}
