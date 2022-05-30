<?php

declare (strict_types=1);
namespace ConfigTransformer202205306\Symplify\PhpConfigPrinter\NodeVisitor;

use ConfigTransformer202205306\PhpParser\Node;
use ConfigTransformer202205306\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202205306\PhpParser\Node\Name;
use ConfigTransformer202205306\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202205306\PhpParser\NodeVisitorAbstract;
use ConfigTransformer202205306\Symplify\PhpConfigPrinter\Naming\ClassNaming;
use ConfigTransformer202205306\Symplify\PhpConfigPrinter\ValueObject\AttributeKey;
use ConfigTransformer202205306\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport;
use ConfigTransformer202205306\Symplify\PhpConfigPrinter\ValueObject\ImportType;
final class ImportFullyQualifiedNamesNodeVisitor extends \ConfigTransformer202205306\PhpParser\NodeVisitorAbstract
{
    /**
     * @var FullyQualifiedImport[]
     */
    private $imports = [];
    /**
     * @var \Symplify\PhpConfigPrinter\Naming\ClassNaming
     */
    private $classNaming;
    public function __construct(\ConfigTransformer202205306\Symplify\PhpConfigPrinter\Naming\ClassNaming $classNaming)
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
    public function enterNode(\ConfigTransformer202205306\PhpParser\Node $node) : ?\ConfigTransformer202205306\PhpParser\Node
    {
        if (!$node instanceof \ConfigTransformer202205306\PhpParser\Node\Name\FullyQualified) {
            return null;
        }
        $parent = $node->getAttribute(\ConfigTransformer202205306\Symplify\PhpConfigPrinter\ValueObject\AttributeKey::PARENT);
        $fullyQualifiedName = $node->toString();
        if (\strncmp($fullyQualifiedName, '\\', \strlen('\\')) === 0) {
            $fullyQualifiedName = \ltrim($fullyQualifiedName, '\\');
        }
        if (\strpos($fullyQualifiedName, '\\') === \false) {
            return new \ConfigTransformer202205306\PhpParser\Node\Name($fullyQualifiedName);
        }
        $shortClassName = $this->classNaming->getShortName($fullyQualifiedName);
        if ($parent instanceof \ConfigTransformer202205306\PhpParser\Node\Expr\FuncCall) {
            $import = new \ConfigTransformer202205306\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport(\ConfigTransformer202205306\Symplify\PhpConfigPrinter\ValueObject\ImportType::FUNCTION_TYPE, $fullyQualifiedName);
        } else {
            $import = new \ConfigTransformer202205306\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport(\ConfigTransformer202205306\Symplify\PhpConfigPrinter\ValueObject\ImportType::CLASS_TYPE, $fullyQualifiedName);
        }
        $this->imports[] = $import;
        return new \ConfigTransformer202205306\PhpParser\Node\Name($shortClassName);
    }
    /**
     * @return FullyQualifiedImport[]
     */
    public function getImports() : array
    {
        return $this->imports;
    }
}
