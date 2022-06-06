<?php

declare (strict_types=1);
namespace ConfigTransformer202206063\PhpParser\Node\Expr\Cast;

use ConfigTransformer202206063\PhpParser\Node\Expr\Cast;
class Unset_ extends \ConfigTransformer202206063\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Unset';
    }
}
