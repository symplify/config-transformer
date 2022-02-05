<?php

declare (strict_types=1);
namespace ConfigTransformer2022020510\PhpParser\Node\Expr\Cast;

use ConfigTransformer2022020510\PhpParser\Node\Expr\Cast;
class Object_ extends \ConfigTransformer2022020510\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Object';
    }
}
