<?php

declare (strict_types=1);
namespace ConfigTransformer202106121\PhpParser\Node\Expr\Cast;

use ConfigTransformer202106121\PhpParser\Node\Expr\Cast;
class Unset_ extends \ConfigTransformer202106121\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Unset';
    }
}
