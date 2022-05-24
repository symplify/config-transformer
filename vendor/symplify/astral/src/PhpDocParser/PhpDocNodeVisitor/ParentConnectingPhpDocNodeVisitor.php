<?php

declare (strict_types=1);
namespace ConfigTransformer2022052410\Symplify\Astral\PhpDocParser\PhpDocNodeVisitor;

use ConfigTransformer2022052410\PHPStan\PhpDocParser\Ast\Node;
use ConfigTransformer2022052410\Symplify\Astral\PhpDocParser\ValueObject\PhpDocAttributeKey;
/**
 * @api
 *
 * Mimics https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitor/ParentConnectingVisitor.php
 *
 * @see \Symplify\Astral\Tests\PhpDocParser\PhpDocNodeVisitor\ParentConnectingPhpDocNodeVisitorTest
 */
final class ParentConnectingPhpDocNodeVisitor extends \ConfigTransformer2022052410\Symplify\Astral\PhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor
{
    /**
     * @var Node[]
     */
    private $stack = [];
    public function beforeTraverse(\ConfigTransformer2022052410\PHPStan\PhpDocParser\Ast\Node $node) : void
    {
        $this->stack = [$node];
    }
    public function enterNode(\ConfigTransformer2022052410\PHPStan\PhpDocParser\Ast\Node $node) : \ConfigTransformer2022052410\PHPStan\PhpDocParser\Ast\Node
    {
        if ($this->stack !== []) {
            $parentNode = $this->stack[\count($this->stack) - 1];
            $node->setAttribute(\ConfigTransformer2022052410\Symplify\Astral\PhpDocParser\ValueObject\PhpDocAttributeKey::PARENT, $parentNode);
        }
        $this->stack[] = $node;
        return $node;
    }
    /**
     * @return int|\PhpParser\Node|mixed[]|null Replacement node (or special return
     */
    public function leaveNode(\ConfigTransformer2022052410\PHPStan\PhpDocParser\Ast\Node $node)
    {
        \array_pop($this->stack);
        return null;
    }
}
