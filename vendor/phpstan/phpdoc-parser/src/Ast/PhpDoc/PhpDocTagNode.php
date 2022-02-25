<?php

declare (strict_types=1);
namespace ConfigTransformer202202253\PHPStan\PhpDocParser\Ast\PhpDoc;

use ConfigTransformer202202253\PHPStan\PhpDocParser\Ast\NodeAttributes;
class PhpDocTagNode implements \ConfigTransformer202202253\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode
{
    use NodeAttributes;
    /** @var string */
    public $name;
    /** @var PhpDocTagValueNode */
    public $value;
    public function __construct(string $name, \ConfigTransformer202202253\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
    public function __toString() : string
    {
        return \trim("{$this->name} {$this->value}");
    }
}
