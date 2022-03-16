<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\PHPStan\PhpDocParser\Ast\PhpDoc;

use ConfigTransformer2022031610\PHPStan\PhpDocParser\Ast\NodeAttributes;
use ConfigTransformer2022031610\PHPStan\PhpDocParser\Ast\Type\TypeNode;
class TypeAliasTagValueNode implements \ConfigTransformer2022031610\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    use NodeAttributes;
    /** @var string */
    public $alias;
    /** @var TypeNode */
    public $type;
    public function __construct(string $alias, \ConfigTransformer2022031610\PHPStan\PhpDocParser\Ast\Type\TypeNode $type)
    {
        $this->alias = $alias;
        $this->type = $type;
    }
    public function __toString() : string
    {
        return \trim("{$this->alias} {$this->type}");
    }
}
