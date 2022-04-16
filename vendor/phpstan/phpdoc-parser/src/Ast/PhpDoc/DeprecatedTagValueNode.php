<?php

declare (strict_types=1);
namespace ConfigTransformer202204166\PHPStan\PhpDocParser\Ast\PhpDoc;

use ConfigTransformer202204166\PHPStan\PhpDocParser\Ast\NodeAttributes;
use function trim;
class DeprecatedTagValueNode implements \ConfigTransformer202204166\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
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
