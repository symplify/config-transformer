<?php

declare (strict_types=1);
namespace ConfigTransformer202112238\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202112238\PhpParser\Node\Scalar\MagicConst;
class Trait_ extends \ConfigTransformer202112238\PhpParser\Node\Scalar\MagicConst
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
