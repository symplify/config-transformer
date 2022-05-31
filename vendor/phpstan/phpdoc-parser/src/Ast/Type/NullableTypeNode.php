<?php

declare (strict_types=1);
namespace ConfigTransformer202205317\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202205317\PHPStan\PhpDocParser\Ast\NodeAttributes;
class NullableTypeNode implements \ConfigTransformer202205317\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var TypeNode */
    public $type;
    public function __construct(\ConfigTransformer202205317\PHPStan\PhpDocParser\Ast\Type\TypeNode $type)
    {
        $this->type = $type;
    }
    public function __toString() : string
    {
        return '?' . $this->type;
    }
}
