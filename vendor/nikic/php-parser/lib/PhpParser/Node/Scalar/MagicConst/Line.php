<?php

declare (strict_types=1);
namespace ConfigTransformer202205033\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202205033\PhpParser\Node\Scalar\MagicConst;
class Line extends \ConfigTransformer202205033\PhpParser\Node\Scalar\MagicConst
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
