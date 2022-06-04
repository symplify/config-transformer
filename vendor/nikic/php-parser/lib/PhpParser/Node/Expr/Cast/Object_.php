<?php

declare (strict_types=1);
namespace ConfigTransformer202206044\PhpParser\Node\Expr\Cast;

use ConfigTransformer202206044\PhpParser\Node\Expr\Cast;
class Object_ extends \ConfigTransformer202206044\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Object';
    }
}
