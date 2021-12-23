<?php

declare (strict_types=1);
namespace ConfigTransformer202112233\PhpParser\Node\Expr\Cast;

use ConfigTransformer202112233\PhpParser\Node\Expr\Cast;
class Unset_ extends \ConfigTransformer202112233\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Unset';
    }
}
