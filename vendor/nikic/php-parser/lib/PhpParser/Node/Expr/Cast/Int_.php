<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\PhpParser\Node\Expr\Cast;

use ConfigTransformer2022060710\PhpParser\Node\Expr\Cast;
class Int_ extends Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Int';
    }
}
