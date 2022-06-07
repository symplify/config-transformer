<?php

declare (strict_types=1);
namespace ConfigTransformer202206079\PhpParser\Node\Expr\Cast;

use ConfigTransformer202206079\PhpParser\Node\Expr\Cast;
class Bool_ extends Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Bool';
    }
}
