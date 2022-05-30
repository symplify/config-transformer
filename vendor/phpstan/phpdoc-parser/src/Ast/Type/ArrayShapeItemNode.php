<?php

declare (strict_types=1);
namespace ConfigTransformer202205306\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer202205306\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use ConfigTransformer202205306\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
use ConfigTransformer202205306\PHPStan\PhpDocParser\Ast\NodeAttributes;
use function sprintf;
class ArrayShapeItemNode implements \ConfigTransformer202205306\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    /** @var ConstExprIntegerNode|ConstExprStringNode|IdentifierTypeNode|null */
    public $keyName;
    /** @var bool */
    public $optional;
    /** @var TypeNode */
    public $valueType;
    /**
     * @param ConstExprIntegerNode|ConstExprStringNode|IdentifierTypeNode|null $keyName
     */
    public function __construct($keyName, bool $optional, \ConfigTransformer202205306\PHPStan\PhpDocParser\Ast\Type\TypeNode $valueType)
    {
        $this->keyName = $keyName;
        $this->optional = $optional;
        $this->valueType = $valueType;
    }
    public function __toString() : string
    {
        if ($this->keyName !== null) {
            return \sprintf('%s%s: %s', (string) $this->keyName, $this->optional ? '?' : '', (string) $this->valueType);
        }
        return (string) $this->valueType;
    }
}
