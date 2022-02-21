<?php

declare (strict_types=1);
namespace ConfigTransformer2022022110\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer2022022110\PhpParser\Node\Scalar\MagicConst;
class Trait_ extends \ConfigTransformer2022022110\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__TRAIT__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Trait';
    }
}
