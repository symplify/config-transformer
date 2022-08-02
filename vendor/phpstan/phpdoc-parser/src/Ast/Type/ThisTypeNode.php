<?php

declare (strict_types=1);
namespace ConfigTransformer202208\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202208\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ThisTypeNode implements TypeNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        return '$this';
    }
}
