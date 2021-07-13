<?php

declare (strict_types=1);
namespace ConfigTransformer202107131\Symplify\PhpConfigPrinter\NodeVisitor;

use ConfigTransformer202107131\PhpParser\Node;
use ConfigTransformer202107131\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202107131\PhpParser\Node\Name;
use ConfigTransformer202107131\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202107131\PhpParser\NodeVisitorAbstract;
use ConfigTransformer202107131\Symplify\PhpConfigPrinter\Naming\ClassNaming;
use ConfigTransformer202107131\Symplify\PhpConfigPrinter\ValueObject\AttributeKey;
use ConfigTransformer202107131\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport;
use ConfigTransformer202107131\Symplify\PhpConfigPrinter\ValueObject\ImportType;
final class ImportFullyQualifiedNamesNodeVisitor extends \ConfigTransformer202107131\PhpParser\NodeVisitorAbstract
{
    /**
     * @var FullyQualifiedImport[]
     */
    private $imports = [];
    /**
     * @var \Symplify\PhpConfigPrinter\Naming\ClassNaming
     */
    private $classNaming;
    public function __construct(\ConfigTransformer202107131\Symplify\PhpConfigPrinter\Naming\ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }
    /**
     * @param Node[] $nodes
     * @return Node[]|null
     */
    public function beforeTraverse($nodes) : ?array
    {
        $this->imports = [];
        return null;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function enterNode($node) : ?\ConfigTransformer202107131\PhpParser\Node
    {
        if (!$node instanceof \ConfigTransformer202107131\PhpParser\Node\Name\FullyQualified) {
            return null;
        }
        $parent = $node->getAttribute(\ConfigTransformer202107131\Symplify\PhpConfigPrinter\ValueObject\AttributeKey::PARENT);
        $fullyQualifiedName = $node->toString();
        if (\strncmp($fullyQualifiedName, '\\', \strlen('\\')) === 0) {
            $fullyQualifiedName = \ltrim($fullyQualifiedName, '\\');
        }
        if (\strpos($fullyQualifiedName, '\\') === \false) {
            return new \ConfigTransformer202107131\PhpParser\Node\Name($fullyQualifiedName);
        }
        $shortClassName = $this->classNaming->getShortName($fullyQualifiedName);
        if ($parent instanceof \ConfigTransformer202107131\PhpParser\Node\Expr\FuncCall) {
            $import = new \ConfigTransformer202107131\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport(\ConfigTransformer202107131\Symplify\PhpConfigPrinter\ValueObject\ImportType::FUNCTION_TYPE, $fullyQualifiedName);
        } else {
            $import = new \ConfigTransformer202107131\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport(\ConfigTransformer202107131\Symplify\PhpConfigPrinter\ValueObject\ImportType::CLASS_TYPE, $fullyQualifiedName);
        }
        $this->imports[] = $import;
        return new \ConfigTransformer202107131\PhpParser\Node\Name($shortClassName);
    }
    /**
     * @return FullyQualifiedImport[]
     */
    public function getImports() : array
    {
        return $this->imports;
    }
}
