<?php

declare (strict_types=1);
namespace ConfigTransformer20220610\PHPStan\PhpDocParser\Ast\PhpDoc;

use ConfigTransformer20220610\PHPStan\PhpDocParser\Ast\NodeAttributes;
use ConfigTransformer20220610\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use function trim;
class MixinTagValueNode implements PhpDocTagValueNode
{
    use NodeAttributes;
    /** @var TypeNode */
    public $type;
    /** @var string (may be empty) */
    public $description;
    public function __construct(TypeNode $type, string $description)
    {
        $this->type = $type;
        $this->description = $description;
    }
    public function __toString() : string
    {
        return trim("{$this->type} {$this->description}");
    }
}
