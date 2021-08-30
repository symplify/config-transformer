<?php

declare (strict_types=1);
namespace ConfigTransformer2021083010\PhpParser\Node\Expr\Cast;

use ConfigTransformer2021083010\PhpParser\Node\Expr\Cast;
class String_ extends \ConfigTransformer2021083010\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_String';
    }
}
