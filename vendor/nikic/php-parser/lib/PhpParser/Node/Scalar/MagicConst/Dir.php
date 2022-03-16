<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer2022031610\PhpParser\Node\Scalar\MagicConst;
class Dir extends \ConfigTransformer2022031610\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__DIR__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Dir';
    }
}
