<?php

declare (strict_types=1);
namespace ConfigTransformer202111117\PhpParser\Node\Expr\Cast;

use ConfigTransformer202111117\PhpParser\Node\Expr\Cast;
class Int_ extends \ConfigTransformer202111117\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Int';
    }
}
