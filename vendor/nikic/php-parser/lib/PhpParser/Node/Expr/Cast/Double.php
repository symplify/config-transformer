<?php

declare (strict_types=1);
namespace ConfigTransformer202107130\PhpParser\Node\Expr\Cast;

use ConfigTransformer202107130\PhpParser\Node\Expr\Cast;
class Double extends \ConfigTransformer202107130\PhpParser\Node\Expr\Cast
{
    // For use in "kind" attribute
    const KIND_DOUBLE = 1;
    // "double" syntax
    const KIND_FLOAT = 2;
    // "float" syntax
    const KIND_REAL = 3;
    // "real" syntax
    public function getType() : string
    {
        return 'Expr_Cast_Double';
    }
}
