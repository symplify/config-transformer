<?php

declare (strict_types=1);
namespace ConfigTransformer2022051110\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer2022051110\PHPStan\PhpDocParser\Ast\NodeAttributes;
class OffsetAccessTypeNode implements \ConfigTransformer2022051110\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var TypeNode */
    public $type;
    /** @var TypeNode */
    public $offset;
    public function __construct(\ConfigTransformer2022051110\PHPStan\PhpDocParser\Ast\Type\TypeNode $type, \ConfigTransformer2022051110\PHPStan\PhpDocParser\Ast\Type\TypeNode $offset)
    {
        $this->type = $type;
        $this->offset = $offset;
    }
    public function __toString() : string
    {
        return $this->type . '[' . $this->offset . ']';
    }
}
