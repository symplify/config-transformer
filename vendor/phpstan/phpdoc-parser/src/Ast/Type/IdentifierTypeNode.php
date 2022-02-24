<?php

declare (strict_types=1);
namespace ConfigTransformer202202240\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202202240\PHPStan\PhpDocParser\Ast\NodeAttributes;
class IdentifierTypeNode implements \ConfigTransformer202202240\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var string */
    public $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    public function __toString() : string
    {
        return $this->name;
    }
}
