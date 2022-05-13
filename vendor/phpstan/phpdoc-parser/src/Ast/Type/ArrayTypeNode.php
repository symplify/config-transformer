<?php

declare (strict_types=1);
namespace ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ArrayTypeNode implements \ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var TypeNode */
    public $type;
    public function __construct(\ConfigTransformer2022051310\PHPStan\PhpDocParser\Ast\Type\TypeNode $type)
    {
        $this->type = $type;
    }
    public function __toString() : string
    {
        return $this->type . '[]';
    }
}
