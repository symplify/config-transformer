<?php

declare (strict_types=1);
namespace ConfigTransformer2022012610\PhpParser\Node\Expr\Cast;

use ConfigTransformer2022012610\PhpParser\Node\Expr\Cast;
class Bool_ extends \ConfigTransformer2022012610\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Bool';
    }
}
