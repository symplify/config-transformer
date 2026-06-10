<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202606\PhpParser\Node\Expr\Cast;

use ConfigTransformerPrefix202606\PhpParser\Node\Expr\Cast;
class Void_ extends Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Void';
    }
}
