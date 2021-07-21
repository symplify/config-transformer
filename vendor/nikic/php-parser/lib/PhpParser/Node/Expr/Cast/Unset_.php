<?php

declare (strict_types=1);
namespace ConfigTransformer2021072110\PhpParser\Node\Expr\Cast;

use ConfigTransformer2021072110\PhpParser\Node\Expr\Cast;
class Unset_ extends \ConfigTransformer2021072110\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Unset';
    }
}
