<?php

declare (strict_types=1);
namespace ConfigTransformer202205010\Symplify\Astral\NodeValue\NodeValueResolver;

use ConfigTransformer202205010\PhpParser\Node\Expr;
use ConfigTransformer202205010\PhpParser\Node\Scalar\MagicConst;
use ConfigTransformer202205010\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformer202205010\PhpParser\Node\Scalar\MagicConst\File;
use ConfigTransformer202205010\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<MagicConst>
 */
final class MagicConstValueResolver implements \ConfigTransformer202205010\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface
{
    public function getType() : string
    {
        return \ConfigTransformer202205010\PhpParser\Node\Scalar\MagicConst::class;
    }
    /**
     * @param MagicConst $expr
     */
    public function resolve(\ConfigTransformer202205010\PhpParser\Node\Expr $expr, string $currentFilePath) : ?string
    {
        if ($expr instanceof \ConfigTransformer202205010\PhpParser\Node\Scalar\MagicConst\Dir) {
            return \dirname($currentFilePath);
        }
        if ($expr instanceof \ConfigTransformer202205010\PhpParser\Node\Scalar\MagicConst\File) {
            return $currentFilePath;
        }
        return null;
    }
}
