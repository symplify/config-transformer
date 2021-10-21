<?php

declare (strict_types=1);
namespace ConfigTransformer202110212\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202110212\PhpParser\Node\Scalar\MagicConst;
class File extends \ConfigTransformer202110212\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__FILE__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_File';
    }
}
