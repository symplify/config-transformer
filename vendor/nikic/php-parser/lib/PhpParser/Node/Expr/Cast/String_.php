<?php

declare (strict_types=1);
namespace ConfigTransformer2022052410\PhpParser\Node\Expr\Cast;

use ConfigTransformer2022052410\PhpParser\Node\Expr\Cast;
class String_ extends \ConfigTransformer2022052410\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_String';
    }
}
