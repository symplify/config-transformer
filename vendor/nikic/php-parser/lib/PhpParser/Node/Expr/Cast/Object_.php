<?php

declare (strict_types=1);
namespace ConfigTransformer202205290\PhpParser\Node\Expr\Cast;

use ConfigTransformer202205290\PhpParser\Node\Expr\Cast;
class Object_ extends \ConfigTransformer202205290\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Object';
    }
}
