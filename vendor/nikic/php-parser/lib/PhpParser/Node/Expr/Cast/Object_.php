<?php

declare (strict_types=1);
namespace ConfigTransformer202107055\PhpParser\Node\Expr\Cast;

use ConfigTransformer202107055\PhpParser\Node\Expr\Cast;
class Object_ extends \ConfigTransformer202107055\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Object';
    }
}