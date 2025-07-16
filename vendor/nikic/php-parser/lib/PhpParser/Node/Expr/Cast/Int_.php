<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202507\PhpParser\Node\Expr\Cast;

use ConfigTransformerPrefix202507\PhpParser\Node\Expr\Cast;
class Int_ extends Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Int';
    }
}
