<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202501\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformerPrefix202501\PhpParser\Node\Scalar\MagicConst;
class Line extends MagicConst
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
