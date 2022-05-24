<?php

declare (strict_types=1);
namespace ConfigTransformer2022052410\PHPStan\PhpDocParser\Ast\PhpDoc;

use ConfigTransformer2022052410\PHPStan\PhpDocParser\Ast\NodeAttributes;
use ConfigTransformer2022052410\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode;
use function trim;
class ImplementsTagValueNode implements \ConfigTransformer2022052410\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    use NodeAttributes;
    /** @var GenericTypeNode */
    public $type;
    /** @var string (may be empty) */
    public $description;
    public function __construct(\ConfigTransformer2022052410\PHPStan\PhpDocParser\Ast\Type\GenericTypeNode $type, string $description)
    {
        $this->type = $type;
        $this->description = $description;
    }
    public function __toString() : string
    {
        return \trim("{$this->type} {$this->description}");
    }
}
