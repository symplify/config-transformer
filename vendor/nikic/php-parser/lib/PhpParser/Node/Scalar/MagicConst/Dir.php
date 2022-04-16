<?php

declare (strict_types=1);
namespace ConfigTransformer202204162\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202204162\PhpParser\Node\Scalar\MagicConst;
class Dir extends \ConfigTransformer202204162\PhpParser\Node\Scalar\MagicConst
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
