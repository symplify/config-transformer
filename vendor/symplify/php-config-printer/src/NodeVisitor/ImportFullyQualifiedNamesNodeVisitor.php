<?php

declare (strict_types=1);
namespace ConfigTransformer2021091710\Symplify\PhpConfigPrinter\NodeVisitor;

use ConfigTransformer2021091710\PhpParser\Node;
use ConfigTransformer2021091710\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer2021091710\PhpParser\Node\Name;
use ConfigTransformer2021091710\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer2021091710\PhpParser\NodeVisitorAbstract;
use ConfigTransformer2021091710\Symplify\PhpConfigPrinter\Naming\ClassNaming;
use ConfigTransformer2021091710\Symplify\PhpConfigPrinter\ValueObject\AttributeKey;
use ConfigTransformer2021091710\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport;
use ConfigTransformer2021091710\Symplify\PhpConfigPrinter\ValueObject\ImportType;
final class ImportFullyQualifiedNamesNodeVisitor extends \ConfigTransformer2021091710\PhpParser\NodeVisitorAbstract
{
    /**
     * @var FullyQualifiedImport[]
     */
    private $imports = [];
    /**
     * @var \Symplify\PhpConfigPrinter\Naming\ClassNaming
     */
    private $classNaming;
    public function __construct(\ConfigTransformer2021091710\Symplify\PhpConfigPrinter\Naming\ClassNaming $classNaming)
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
    public function enterNode($node) : ?\ConfigTransformer2021091710\PhpParser\Node
    {
        if (!$node instanceof \ConfigTransformer2021091710\PhpParser\Node\Name\FullyQualified) {
            return null;
        }
        $parent = $node->getAttribute(\ConfigTransformer2021091710\Symplify\PhpConfigPrinter\ValueObject\AttributeKey::PARENT);
        $fullyQualifiedName = $node->toString();
        if (\strncmp($fullyQualifiedName, '\\', \strlen('\\')) === 0) {
            $fullyQualifiedName = \ltrim($fullyQualifiedName, '\\');
        }
        if (\strpos($fullyQualifiedName, '\\') === \false) {
            return new \ConfigTransformer2021091710\PhpParser\Node\Name($fullyQualifiedName);
        }
        $shortClassName = $this->classNaming->getShortName($fullyQualifiedName);
        if ($parent instanceof \ConfigTransformer2021091710\PhpParser\Node\Expr\FuncCall) {
            $import = new \ConfigTransformer2021091710\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport(\ConfigTransformer2021091710\Symplify\PhpConfigPrinter\ValueObject\ImportType::FUNCTION_TYPE, $fullyQualifiedName);
        } else {
            $import = new \ConfigTransformer2021091710\Symplify\PhpConfigPrinter\ValueObject\FullyQualifiedImport(\ConfigTransformer2021091710\Symplify\PhpConfigPrinter\ValueObject\ImportType::CLASS_TYPE, $fullyQualifiedName);
        }
        $this->imports[] = $import;
        return new \ConfigTransformer2021091710\PhpParser\Node\Name($shortClassName);
    }
    /**
     * @return FullyQualifiedImport[]
     */
    public function getImports() : array
    {
        return $this->imports;
    }
}
