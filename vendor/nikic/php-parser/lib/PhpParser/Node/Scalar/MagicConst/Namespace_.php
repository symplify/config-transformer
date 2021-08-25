<?php

declare (strict_types=1);
namespace ConfigTransformer2021082510\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer2021082510\PhpParser\Node\Scalar\MagicConst;
class Namespace_ extends \ConfigTransformer2021082510\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__NAMESPACE__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Namespace';
    }
}
