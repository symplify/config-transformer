<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer2022060710\PhpParser\Node\Scalar\MagicConst;
class Function_ extends MagicConst
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
