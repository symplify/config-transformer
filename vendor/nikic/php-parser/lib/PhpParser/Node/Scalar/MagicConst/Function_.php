<?php

declare (strict_types=1);
namespace ConfigTransformer2021061110\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer2021061110\PhpParser\Node\Scalar\MagicConst;
class Function_ extends \ConfigTransformer2021061110\PhpParser\Node\Scalar\MagicConst
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
