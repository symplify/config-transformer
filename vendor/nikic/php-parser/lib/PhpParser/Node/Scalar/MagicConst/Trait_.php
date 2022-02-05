<?php

declare (strict_types=1);
namespace ConfigTransformer2022020510\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer2022020510\PhpParser\Node\Scalar\MagicConst;
class Trait_ extends \ConfigTransformer2022020510\PhpParser\Node\Scalar\MagicConst
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
