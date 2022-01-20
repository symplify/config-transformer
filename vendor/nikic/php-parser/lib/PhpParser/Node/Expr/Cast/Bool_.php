<?php

declare (strict_types=1);
namespace ConfigTransformer202201209\PhpParser\Node\Expr\Cast;

use ConfigTransformer202201209\PhpParser\Node\Expr\Cast;
class Bool_ extends \ConfigTransformer202201209\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Bool';
    }
}
