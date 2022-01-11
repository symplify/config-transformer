<?php

declare (strict_types=1);
namespace ConfigTransformer2022011110\PhpParser\Node\Expr\Cast;

use ConfigTransformer2022011110\PhpParser\Node\Expr\Cast;
class Object_ extends \ConfigTransformer2022011110\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Object';
    }
}
