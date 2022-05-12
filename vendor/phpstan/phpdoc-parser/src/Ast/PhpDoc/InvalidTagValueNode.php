<?php

declare (strict_types=1);
namespace ConfigTransformer202205129\PHPStan\PhpDocParser\Ast\PhpDoc;

use ConfigTransformer202205129\PHPStan\PhpDocParser\Ast\NodeAttributes;
use ConfigTransformer202205129\PHPStan\PhpDocParser\Parser\ParserException;
use function sprintf;
use function trigger_error;
use const E_USER_WARNING;
/**
 * @property ParserException $exception
 */
class InvalidTagValueNode implements \ConfigTransformer202205129\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    use NodeAttributes;
    /** @var string (may be empty) */
    public $value;
    /** @var mixed[] */
    private $exceptionArgs;
    public function __construct(string $value, \ConfigTransformer202205129\PHPStan\PhpDocParser\Parser\ParserException $exception)
    {
        $this->value = $value;
        $this->exceptionArgs = [$exception->getCurrentTokenValue(), $exception->getCurrentTokenType(), $exception->getCurrentOffset(), $exception->getExpectedTokenType(), $exception->getExpectedTokenValue()];
    }
    public function __get(string $name)
    {
        if ($name !== 'exception') {
            \trigger_error(\sprintf('Undefined property: %s::$%s', self::class, $name), \E_USER_WARNING);
            return null;
        }
        return new \ConfigTransformer202205129\PHPStan\PhpDocParser\Parser\ParserException(...$this->exceptionArgs);
    }
    public function __toString() : string
    {
        return $this->value;
    }
}
