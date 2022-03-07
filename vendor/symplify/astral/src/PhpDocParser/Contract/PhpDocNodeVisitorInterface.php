<?php

declare (strict_types=1);
namespace ConfigTransformer2022030710\Symplify\Astral\PhpDocParser\Contract;

use ConfigTransformer2022030710\PHPStan\PhpDocParser\Ast\Node;
/**
 * Inspired by https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitor.php
 */
interface PhpDocNodeVisitorInterface
{
    public function beforeTraverse(\ConfigTransformer2022030710\PHPStan\PhpDocParser\Ast\Node $node) : void;
    /**
     * @return int|Node|null
     */
    public function enterNode(\ConfigTransformer2022030710\PHPStan\PhpDocParser\Ast\Node $node);
    /**
     * @return null|int|\PhpParser\Node|Node[] Replacement node (or special return)
     */
    public function leaveNode(\ConfigTransformer2022030710\PHPStan\PhpDocParser\Ast\Node $node);
    public function afterTraverse(\ConfigTransformer2022030710\PHPStan\PhpDocParser\Ast\Node $node) : void;
}
