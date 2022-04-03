<?php

declare (strict_types=1);
namespace ConfigTransformer202204039\Symplify\Astral\PhpDocParser\PhpDocNodeVisitor;

use ConfigTransformer202204039\PHPStan\PhpDocParser\Ast\Node;
use ConfigTransformer202204039\Symplify\Astral\PhpDocParser\ValueObject\PhpDocAttributeKey;
/**
 * @api
 *
 * Mirrors
 * https://github.com/nikic/PHP-Parser/blob/d520bc9e1d6203c35a1ba20675b79a051c821a9e/lib/PhpParser/NodeVisitor/CloningVisitor.php
 */
final class CloningPhpDocNodeVisitor extends \ConfigTransformer202204039\Symplify\Astral\PhpDocParser\PhpDocNodeVisitor\AbstractPhpDocNodeVisitor
{
    public function enterNode(\ConfigTransformer202204039\PHPStan\PhpDocParser\Ast\Node $node) : \ConfigTransformer202204039\PHPStan\PhpDocParser\Ast\Node
    {
        $clonedNode = clone $node;
        $clonedNode->setAttribute(\ConfigTransformer202204039\Symplify\Astral\PhpDocParser\ValueObject\PhpDocAttributeKey::ORIG_NODE, $node);
        return $clonedNode;
    }
}
