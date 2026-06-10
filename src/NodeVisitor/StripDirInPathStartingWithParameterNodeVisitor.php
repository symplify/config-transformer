<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\NodeVisitor;

use ConfigTransformerPrefix202606\PhpParser\Node;
use ConfigTransformerPrefix202606\PhpParser\Node\Expr\BinaryOp\Concat;
use ConfigTransformerPrefix202606\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformerPrefix202606\PhpParser\Node\Scalar\String_;
use ConfigTransformerPrefix202606\PhpParser\NodeVisitorAbstract;
/**
 * Turns `__DIR__ . '/%kernel.project_dir%/src/Article'` into
 * `'%kernel.project_dir%/src/Article'`, so Symfony parameters in paths
 * stay intact instead of being prefixed with the current directory.
 */
final class StripDirInPathStartingWithParameterNodeVisitor extends NodeVisitorAbstract
{
    public function enterNode(Node $node) : ?Node
    {
        if (!$node instanceof Concat) {
            return null;
        }
        if (!$node->left instanceof Dir) {
            return null;
        }
        if (!$node->right instanceof String_) {
            return null;
        }
        $value = $node->right->value;
        if (\strncmp($value, '/%', \strlen('/%')) !== 0) {
            return null;
        }
        return new String_(\ltrim($value, '/'));
    }
}
