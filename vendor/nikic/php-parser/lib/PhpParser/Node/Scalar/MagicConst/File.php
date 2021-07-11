<?php

declare (strict_types=1);
namespace ConfigTransformer202107112\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202107112\PhpParser\Node\Scalar\MagicConst;
class File extends \ConfigTransformer202107112\PhpParser\Node\Scalar\MagicConst
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
