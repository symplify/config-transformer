<?php

declare (strict_types=1);
namespace ConfigTransformer202204162\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202204162\PhpParser\Node\Scalar\MagicConst;
class Class_ extends \ConfigTransformer202204162\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__CLASS__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Class';
    }
}
