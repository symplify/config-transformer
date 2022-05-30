<?php

declare (strict_types=1);
namespace ConfigTransformer202205308\PHPStan\PhpDocParser\Ast\PhpDoc;

use ConfigTransformer202205308\PHPStan\PhpDocParser\Ast\NodeAttributes;
class PhpDocTextNode implements \ConfigTransformer202205308\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocChildNode
{
    use NodeAttributes;
    /** @var string */
    public $text;
    public function __construct(string $text)
    {
        $this->text = $text;
    }
    public function __toString() : string
    {
        return $this->text;
    }
}
