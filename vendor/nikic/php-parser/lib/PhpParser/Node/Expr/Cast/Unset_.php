<?php

declare (strict_types=1);
namespace ConfigTransformer2022030710\PhpParser\Node\Expr\Cast;

use ConfigTransformer2022030710\PhpParser\Node\Expr\Cast;
class Unset_ extends \ConfigTransformer2022030710\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Unset';
    }
}
