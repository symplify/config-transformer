<?php

declare (strict_types=1);
namespace ConfigTransformer202203077\PHPStan\PhpDocParser\Ast\PhpDoc;

use ConfigTransformer202203077\PHPStan\PhpDocParser\Ast\NodeAttributes;
class DeprecatedTagValueNode implements \ConfigTransformer202203077\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    use NodeAttributes;
    /** @var string (may be empty) */
    public $description;
    public function __construct(string $description)
    {
        $this->description = $description;
    }
    public function __toString() : string
    {
        return \trim($this->description);
    }
}
