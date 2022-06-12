<?php

declare (strict_types=1);
namespace ConfigTransformer20220612\PhpParser\Node\Expr\Cast;

use ConfigTransformer20220612\PhpParser\Node\Expr\Cast;
class Object_ extends Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Object';
    }
}
