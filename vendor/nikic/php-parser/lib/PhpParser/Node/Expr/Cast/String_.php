<?php

declare (strict_types=1);
namespace ConfigTransformer202209\PhpParser\Node\Expr\Cast;

use ConfigTransformer202209\PhpParser\Node\Expr\Cast;
class String_ extends Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_String';
    }
}
