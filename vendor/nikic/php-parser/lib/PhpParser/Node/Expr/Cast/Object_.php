<?php

declare (strict_types=1);
namespace ConfigTransformer202110143\PhpParser\Node\Expr\Cast;

use ConfigTransformer202110143\PhpParser\Node\Expr\Cast;
class Object_ extends \ConfigTransformer202110143\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Object';
    }
}
