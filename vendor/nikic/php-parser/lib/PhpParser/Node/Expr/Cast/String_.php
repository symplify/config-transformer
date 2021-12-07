<?php

declare (strict_types=1);
namespace ConfigTransformer202112075\PhpParser\Node\Expr\Cast;

use ConfigTransformer202112075\PhpParser\Node\Expr\Cast;
class String_ extends \ConfigTransformer202112075\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_String';
    }
}
