<?php

declare (strict_types=1);
namespace ConfigTransformer202203075\PHPStan\PhpDocParser\Ast\PhpDoc;

use ConfigTransformer202203075\PHPStan\PhpDocParser\Ast\NodeAttributes;
class GenericTagValueNode implements \ConfigTransformer202203075\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    use NodeAttributes;
    /** @var string (may be empty) */
    public $value;
    public function __construct(string $value)
    {
        $this->value = $value;
    }
    public function __toString() : string
    {
        return $this->value;
    }
}
