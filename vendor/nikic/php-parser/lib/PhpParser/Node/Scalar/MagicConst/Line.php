<?php

declare (strict_types=1);
namespace ConfigTransformer202203076\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202203076\PhpParser\Node\Scalar\MagicConst;
class Line extends \ConfigTransformer202203076\PhpParser\Node\Scalar\MagicConst
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
