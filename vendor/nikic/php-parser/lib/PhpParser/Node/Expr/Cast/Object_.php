<?php

declare (strict_types=1);
namespace ConfigTransformer202203163\PhpParser\Node\Expr\Cast;

use ConfigTransformer202203163\PhpParser\Node\Expr\Cast;
class Object_ extends \ConfigTransformer202203163\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Object';
    }
}
