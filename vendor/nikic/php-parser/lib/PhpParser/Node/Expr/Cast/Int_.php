<?php

declare (strict_types=1);
namespace ConfigTransformer202107130\PhpParser\Node\Expr\Cast;

use ConfigTransformer202107130\PhpParser\Node\Expr\Cast;
class Int_ extends \ConfigTransformer202107130\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Int';
    }
}
