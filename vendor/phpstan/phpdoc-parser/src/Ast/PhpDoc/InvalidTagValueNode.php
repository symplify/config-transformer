<?php

declare (strict_types=1);
namespace ConfigTransformer202204039\PHPStan\PhpDocParser\Ast\PhpDoc;

use ConfigTransformer202204039\PHPStan\PhpDocParser\Ast\NodeAttributes;
use ConfigTransformer202204039\PHPStan\PhpDocParser\Parser\ParserException;
class InvalidTagValueNode implements \ConfigTransformer202204039\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    use NodeAttributes;
    /** @var string (may be empty) */
    public $value;
    /** @var ParserException */
    public $exception;
    public function __construct(string $value, \ConfigTransformer202204039\PHPStan\PhpDocParser\Parser\ParserException $exception)
    {
        $this->value = $value;
        $this->exception = $exception;
    }
    public function __toString() : string
    {
        return $this->value;
    }
}
