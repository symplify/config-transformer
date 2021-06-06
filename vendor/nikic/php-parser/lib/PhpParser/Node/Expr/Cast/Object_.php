<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\PhpParser\Node\Expr\Cast;

use ConfigTransformer20210606\PhpParser\Node\Expr\Cast;
class Object_ extends \ConfigTransformer20210606\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Object';
    }
}
