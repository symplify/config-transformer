<?php

declare (strict_types=1);
namespace ConfigTransformer202111289\PhpParser\Node\Expr\Cast;

use ConfigTransformer202111289\PhpParser\Node\Expr\Cast;
class Bool_ extends \ConfigTransformer202111289\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Bool';
    }
}
