<?php

declare (strict_types=1);
namespace ConfigTransformer20210610\PhpParser\Node\Expr\Cast;

use ConfigTransformer20210610\PhpParser\Node\Expr\Cast;
class Bool_ extends \ConfigTransformer20210610\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Bool';
    }
}
