<?php

declare (strict_types=1);
namespace ConfigTransformer202107130\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202107130\PhpParser\Node\Scalar\MagicConst;
class Dir extends \ConfigTransformer202107130\PhpParser\Node\Scalar\MagicConst
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
