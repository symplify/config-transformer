<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeVisitor;

use Migrify\ConfigTransformer\Naming\ClassNaming;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\NodeVisitorAbstract;

final class ImportFullyQualifiedNamesNodeVisitor extends NodeVisitorAbstract
{
    /**
     * @var ClassNaming
     */
    private $classNaming;

    /**
     * @var string[]
     */
    private $nameImports = [];

    public function __construct(ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }

    public function beforeTraverse(array $nodes): void
    {
        $this->nameImports = [];
    }

    public function enterNode(Node $node): ?Node
    {
        if (! $node instanceof FullyQualified) {
            return null;
        }

        $fullyQualifiedName = $node->toString();
        $shortClassName = $this->classNaming->getShortName($fullyQualifiedName);

        $this->nameImports[] = $fullyQualifiedName;

        return new Name($shortClassName);
    }

    /**
     * @return string[]
     */
    public function getNameImports(): array
    {
        return $this->nameImports;
    }
}
