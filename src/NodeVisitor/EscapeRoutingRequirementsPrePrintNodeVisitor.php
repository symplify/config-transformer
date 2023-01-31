<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt;
use PhpParser\NodeVisitorAbstract;
use Symplify\ConfigTransformer\Composer\SymfonyDependencyInjectionVersionResolver;
use Symplify\PhpConfigPrinter\Contract\NodeVisitor\PrePrintNodeVisitorInterface;
use Symplify\PhpConfigPrinter\ValueObject\FunctionName;

final class EscapeRoutingRequirementsPrePrintNodeVisitor extends NodeVisitorAbstract implements PrePrintNodeVisitorInterface
{
    public function enterNode(Node $node): ?Node
    {
        if (! $node instanceof Node\Expr\Array_) {
            return null;
        }

        dump($node);
        die;

        return $node;
    }
}
