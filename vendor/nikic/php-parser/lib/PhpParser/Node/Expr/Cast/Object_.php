<?php

declare (strict_types=1);
namespace ConfigTransformer2021082410\PhpParser\Node\Expr\Cast;

use ConfigTransformer2021082410\PhpParser\Node\Expr\Cast;
class Object_ extends \ConfigTransformer2021082410\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Object';
    }
}
