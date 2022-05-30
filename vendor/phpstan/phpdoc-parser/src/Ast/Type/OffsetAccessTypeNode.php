<?php

declare (strict_types=1);
namespace ConfigTransformer202205302\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202205302\PHPStan\PhpDocParser\Ast\NodeAttributes;
class OffsetAccessTypeNode implements \ConfigTransformer202205302\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var TypeNode */
    public $type;
    /** @var TypeNode */
    public $offset;
    public function __construct(\ConfigTransformer202205302\PHPStan\PhpDocParser\Ast\Type\TypeNode $type, \ConfigTransformer202205302\PHPStan\PhpDocParser\Ast\Type\TypeNode $offset)
    {
        $this->type = $type;
        $this->offset = $offset;
    }
    public function __toString() : string
    {
        return $this->type . '[' . $this->offset . ']';
    }
}
