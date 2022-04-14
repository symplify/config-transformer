<?php

declare (strict_types=1);
namespace ConfigTransformer202204144\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202204144\PHPStan\PhpDocParser\Ast\NodeAttributes;
use function sprintf;
class ConditionalTypeNode implements \ConfigTransformer202204144\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var TypeNode */
    public $subjectType;
    /** @var TypeNode */
    public $targetType;
    /** @var TypeNode */
    public $if;
    /** @var TypeNode */
    public $else;
    /** @var bool */
    public $negated;
    public function __construct(\ConfigTransformer202204144\PHPStan\PhpDocParser\Ast\Type\TypeNode $subjectType, \ConfigTransformer202204144\PHPStan\PhpDocParser\Ast\Type\TypeNode $targetType, \ConfigTransformer202204144\PHPStan\PhpDocParser\Ast\Type\TypeNode $if, \ConfigTransformer202204144\PHPStan\PhpDocParser\Ast\Type\TypeNode $else, bool $negated)
    {
        $this->subjectType = $subjectType;
        $this->targetType = $targetType;
        $this->if = $if;
        $this->else = $else;
        $this->negated = $negated;
    }
    public function __toString() : string
    {
        return \sprintf('(%s %s %s ? %s : %s)', $this->subjectType, $this->negated ? 'is not' : 'is', $this->targetType, $this->if, $this->else);
    }
}
