<?php

declare (strict_types=1);
namespace ConfigTransformer202109036\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202109036\PhpParser\Node\Scalar\MagicConst;
class Line extends \ConfigTransformer202109036\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__LINE__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Line';
    }
}
