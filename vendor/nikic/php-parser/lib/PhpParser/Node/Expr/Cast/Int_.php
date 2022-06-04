<?php

declare (strict_types=1);
namespace ConfigTransformer202206048\PhpParser\Node\Expr\Cast;

use ConfigTransformer202206048\PhpParser\Node\Expr\Cast;
class Int_ extends \ConfigTransformer202206048\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Int';
    }
}
