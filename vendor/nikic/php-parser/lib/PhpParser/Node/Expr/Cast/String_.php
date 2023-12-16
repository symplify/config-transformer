<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202312\PhpParser\Node\Expr\Cast;

use ConfigTransformerPrefix202312\PhpParser\Node\Expr\Cast;
class String_ extends Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_String';
    }
}
