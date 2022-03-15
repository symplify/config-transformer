<?php

declare (strict_types=1);
namespace ConfigTransformer202203157\Symplify\PhpConfigPrinter\NodeVisitor;

use ConfigTransformer202203157\PhpParser\Node;
use ConfigTransformer202203157\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202203157\PhpParser\Node\Name;
use ConfigTransformer202203157\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202203157\PhpParser\NodeVisitorAbstract;
use ConfigTransformer202203157\Symplify\PhpConfigPrinter\Naming\ClassNaming;
use ConfigTransformer202203157\Symplify\PhpConfigPrinter\ValueObject\AttributeKey;
use ConfigTransformer202203157\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport;
use ConfigTransformer202203157\Symplify\PhpConfigPrinter\ValueObject\ImportType;
final class ImportFullyQualifiedNamesNodeVisitor extends \ConfigTransformer202203157\PhpParser\NodeVisitorAbstract
{
    /**
     * @var FullyQualifiedImport[]
     */
    private $imports = [];
    /**
     * @var \Symplify\PhpConfigPrinter\Naming\ClassNaming
     */
    private $classNaming;
    public function __construct(\ConfigTransformer202203157\Symplify\PhpConfigPrinter\Naming\ClassNaming $classNaming)
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
    public function enterNode(\ConfigTransformer202203157\PhpParser\Node $node) : ?\ConfigTransformer202203157\PhpParser\Node
    {
        if (!$node instanceof \ConfigTransformer202203157\PhpParser\Node\Name\FullyQualified) {
            return null;
        }
        $parent = $node->getAttribute(\ConfigTransformer202203157\Symplify\PhpConfigPrinter\ValueObject\AttributeKey::PARENT);
        $fullyQualifiedName = $node->toString();
        if (\strncmp($fullyQualifiedName, '\\', \strlen('\\')) === 0) {
            $fullyQualifiedName = \ltrim($fullyQualifiedName, '\\');
        }
        if (\strpos($fullyQualifiedName, '\\') === \false) {
            return new \ConfigTransformer202203157\PhpParser\Node\Name($fullyQualifiedName);
        }
        $shortClassName = $this->classNaming->getShortName($fullyQualifiedName);
        if ($parent instanceof \ConfigTransformer202203157\PhpParser\Node\Expr\FuncCall) {
            $import = new \ConfigTransformer202203157\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport(\ConfigTransformer202203157\Symplify\PhpConfigPrinter\ValueObject\ImportType::FUNCTION_TYPE, $fullyQualifiedName);
        } else {
            $import = new \ConfigTransformer202203157\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport(\ConfigTransformer202203157\Symplify\PhpConfigPrinter\ValueObject\ImportType::CLASS_TYPE, $fullyQualifiedName);
        }
        $this->imports[] = $import;
        return new \ConfigTransformer202203157\PhpParser\Node\Name($shortClassName);
    }
    /**
     * @return FullyQualifiedImport[]
     */
    public function getImports() : array
    {
        return $this->imports;
    }
}
