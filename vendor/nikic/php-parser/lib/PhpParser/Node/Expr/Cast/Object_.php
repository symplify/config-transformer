<?php

declare (strict_types=1);
namespace ConfigTransformer202211\PhpParser\Node\Expr\Cast;

use ConfigTransformer202211\PhpParser\Node\Expr\Cast;
class Object_ extends Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Object';
    }
}
