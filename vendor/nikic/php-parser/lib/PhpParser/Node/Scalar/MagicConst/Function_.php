<?php

declare (strict_types=1);
namespace ConfigTransformer202107129\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202107129\PhpParser\Node\Scalar\MagicConst;
class Function_ extends \ConfigTransformer202107129\PhpParser\Node\Scalar\MagicConst
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
