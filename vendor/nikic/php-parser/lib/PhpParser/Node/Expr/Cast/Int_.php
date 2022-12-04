<?php

declare (strict_types=1);
namespace ConfigTransformer202212\PhpParser\Node\Expr\Cast;

use ConfigTransformer202212\PhpParser\Node\Expr\Cast;
class Int_ extends Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Int';
    }
}
