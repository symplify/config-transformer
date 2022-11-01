<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\NodeVisitor;

use ConfigTransformer202211\PhpParser\Node;
use ConfigTransformer202211\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202211\PhpParser\Node\Name;
use ConfigTransformer202211\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202211\PhpParser\Node\Stmt;
use ConfigTransformer202211\PhpParser\NodeVisitorAbstract;
use Symplify\ConfigTransformer\Composer\SymfonyDependencyInjectionVersionResolver;
use Symplify\PhpConfigPrinter\Contract\NodeVisitor\PrePrintNodeVisitorInterface;
use Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class RefOrServiceFuncCallPrePrintNodeVisitor extends NodeVisitorAbstract implements PrePrintNodeVisitorInterface
{
    /**
     * @var bool|null
     */
    private $shouldReplaceWithRef;
    /**
     * @var \Symplify\ConfigTransformer\Composer\SymfonyDependencyInjectionVersionResolver
     */
    private $symfonyDependencyInjectionVersionResolver;
    public function __construct(SymfonyDependencyInjectionVersionResolver $symfonyDependencyInjectionVersionResolver)
    {
        $this->symfonyDependencyInjectionVersionResolver = $symfonyDependencyInjectionVersionResolver;
    }
    /**
     * @param Stmt[] $nodes
     * @return Stmt[]
     */
    public function beforeTraverse(array $nodes) : ?array
    {
        // value is already resolved
        if ($this->shouldReplaceWithRef !== null) {
            return $nodes;
        }
        $symfonyDependencyInjectionVersion = $this->symfonyDependencyInjectionVersionResolver->resolve();
        // @todo since what Symfony version is the ref() is gone? find out the blog post
        if ($symfonyDependencyInjectionVersion === null || $symfonyDependencyInjectionVersion >= 3.4) {
            $this->shouldReplaceWithRef = \false;
            return $nodes;
        }
        $this->shouldReplaceWithRef = \true;
        return $nodes;
    }
    public function enterNode(Node $node) : ?Node
    {
        if ($this->shouldReplaceWithRef === \false) {
            return null;
        }
        if (!$node instanceof FuncCall) {
            return null;
        }
        if (!$node->name instanceof Name) {
            return null;
        }
        $functionName = $node->name->toString();
        if ($functionName !== FunctionName::SERVICE) {
            return null;
        }
        $node->name = new FullyQualified(FunctionName::REF);
        return $node;
    }
}
