<?php

declare (strict_types=1);
namespace ConfigTransformer2022041410\Symplify\Astral\PhpDocParser\PhpDocNodeVisitor;

use ConfigTransformer2022041410\PHPStan\PhpDocParser\Ast\Node;
use ConfigTransformer2022041410\Symplify\Astral\PhpDocParser\Contract\PhpDocNodeVisitorInterface;
/**
 * Inspired by https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitorAbstract.php
 */
abstract class AbstractPhpDocNodeVisitor implements \ConfigTransformer2022041410\Symplify\Astral\PhpDocParser\Contract\PhpDocNodeVisitorInterface
{
    public function beforeTraverse(\ConfigTransformer2022041410\PHPStan\PhpDocParser\Ast\Node $node) : void
    {
    }
    /**
     * @return int|\PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(\ConfigTransformer2022041410\PHPStan\PhpDocParser\Ast\Node $node)
    {
        return null;
    }
    /**
     * @return mixed[]|int|\PhpParser\Node|null Replacement node (or special return)
     */
    public function leaveNode(\ConfigTransformer2022041410\PHPStan\PhpDocParser\Ast\Node $node)
    {
        return null;
    }
    public function afterTraverse(\ConfigTransformer2022041410\PHPStan\PhpDocParser\Ast\Node $node) : void
    {
    }
}
