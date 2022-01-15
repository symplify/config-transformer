<?php

declare (strict_types=1);
namespace ConfigTransformer202201151\Symplify\Astral\NodeValue\NodeValueResolver;

use ConfigTransformer202201151\PhpParser\Node\Expr;
use ConfigTransformer202201151\PhpParser\Node\Scalar\MagicConst;
use ConfigTransformer202201151\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformer202201151\PhpParser\Node\Scalar\MagicConst\File;
use ConfigTransformer202201151\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<MagicConst>
 */
final class MagicConstValueResolver implements \ConfigTransformer202201151\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface
{
    public function getType() : string
    {
        return \ConfigTransformer202201151\PhpParser\Node\Scalar\MagicConst::class;
    }
    /**
     * @param MagicConst $expr
     */
    public function resolve(\ConfigTransformer202201151\PhpParser\Node\Expr $expr, string $currentFilePath) : ?string
    {
        if ($expr instanceof \ConfigTransformer202201151\PhpParser\Node\Scalar\MagicConst\Dir) {
            return \dirname($currentFilePath);
        }
        if ($expr instanceof \ConfigTransformer202201151\PhpParser\Node\Scalar\MagicConst\File) {
            return $currentFilePath;
        }
        return null;
    }
}
