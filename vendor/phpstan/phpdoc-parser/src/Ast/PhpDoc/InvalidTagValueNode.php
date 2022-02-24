<?php

declare (strict_types=1);
namespace ConfigTransformer202202247\PHPStan\PhpDocParser\Ast\PhpDoc;

use ConfigTransformer202202247\PHPStan\PhpDocParser\Ast\NodeAttributes;
class InvalidTagValueNode implements \ConfigTransformer202202247\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    use NodeAttributes;
    /** @var string (may be empty) */
    public $value;
    /** @var \PHPStan\PhpDocParser\Parser\ParserException */
    public $exception;
    public function __construct(string $value, \ConfigTransformer202202247\PHPStan\PhpDocParser\Parser\ParserException $exception)
    {
        $this->value = $value;
        $this->exception = $exception;
    }
    public function __toString() : string
    {
        return $this->value;
    }
}
