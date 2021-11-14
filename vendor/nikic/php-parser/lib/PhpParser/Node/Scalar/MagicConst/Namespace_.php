<?php

declare (strict_types=1);
namespace ConfigTransformer202111145\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202111145\PhpParser\Node\Scalar\MagicConst;
class Namespace_ extends \ConfigTransformer202111145\PhpParser\Node\Scalar\MagicConst
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
