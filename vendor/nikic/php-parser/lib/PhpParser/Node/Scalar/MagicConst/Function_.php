<?php

declare (strict_types=1);
namespace ConfigTransformer202206076\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202206076\PhpParser\Node\Scalar\MagicConst;
class Function_ extends \ConfigTransformer202206076\PhpParser\Node\Scalar\MagicConst
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
