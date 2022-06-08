<?php

declare (strict_types=1);
namespace ConfigTransformer20220608\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer20220608\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ArrayTypeNode implements TypeNode
{
    use NodeAttributes;
    /** @var TypeNode */
    public $type;
    public function __construct(TypeNode $type)
    {
        $this->type = $type;
    }
    public function __toString() : string
    {
        return $this->type . '[]';
    }
}
