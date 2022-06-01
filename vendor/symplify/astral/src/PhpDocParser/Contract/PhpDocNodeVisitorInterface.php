<?php

declare (strict_types=1);
namespace ConfigTransformer202206010\Symplify\Astral\PhpDocParser\Contract;

use ConfigTransformer202206010\PHPStan\PhpDocParser\Ast\Node;
/**
 * Inspired by https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitor.php
 */
interface PhpDocNodeVisitorInterface
{
    public function beforeTraverse(\ConfigTransformer202206010\PHPStan\PhpDocParser\Ast\Node $node) : void;
    /**
     * @return int|\PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(\ConfigTransformer202206010\PHPStan\PhpDocParser\Ast\Node $node);
    /**
     * @return int|\PhpParser\Node|mixed[]|null Replacement node (or special return)
     */
    public function leaveNode(\ConfigTransformer202206010\PHPStan\PhpDocParser\Ast\Node $node);
    public function afterTraverse(\ConfigTransformer202206010\PHPStan\PhpDocParser\Ast\Node $node) : void;
}
