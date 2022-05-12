<?php

declare (strict_types=1);
namespace ConfigTransformer202205122\Symplify\Astral\PhpDocParser\PhpDocNodeVisitor;

use ConfigTransformer202205122\PHPStan\PhpDocParser\Ast\Node;
use ConfigTransformer202205122\Symplify\Astral\PhpDocParser\Contract\PhpDocNodeVisitorInterface;
/**
 * Inspired by https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitorAbstract.php
 */
abstract class AbstractPhpDocNodeVisitor implements \ConfigTransformer202205122\Symplify\Astral\PhpDocParser\Contract\PhpDocNodeVisitorInterface
{
    public function beforeTraverse(\ConfigTransformer202205122\PHPStan\PhpDocParser\Ast\Node $node) : void
    {
    }
    /**
     * @return int|\PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(\ConfigTransformer202205122\PHPStan\PhpDocParser\Ast\Node $node)
    {
        return null;
    }
    /**
     * @return int|\PhpParser\Node|mixed[]|null Replacement node (or special return)
     */
    public function leaveNode(\ConfigTransformer202205122\PHPStan\PhpDocParser\Ast\Node $node)
    {
        return null;
    }
    public function afterTraverse(\ConfigTransformer202205122\PHPStan\PhpDocParser\Ast\Node $node) : void
    {
    }
}
