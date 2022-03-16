<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer2022031610\PhpParser\Node\Scalar\MagicConst;
class Function_ extends \ConfigTransformer2022031610\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__FUNCTION__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Function';
    }
}
