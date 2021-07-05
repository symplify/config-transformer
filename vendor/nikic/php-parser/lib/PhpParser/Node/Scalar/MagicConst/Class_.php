<?php

declare (strict_types=1);
namespace ConfigTransformer2021070510\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer2021070510\PhpParser\Node\Scalar\MagicConst;
class Class_ extends \ConfigTransformer2021070510\PhpParser\Node\Scalar\MagicConst
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
