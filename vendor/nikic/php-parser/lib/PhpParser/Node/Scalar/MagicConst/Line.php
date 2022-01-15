<?php

declare (strict_types=1);
namespace ConfigTransformer202201158\PhpParser\Node\Scalar\MagicConst;

use ConfigTransformer202201158\PhpParser\Node\Scalar\MagicConst;
class Line extends \ConfigTransformer202201158\PhpParser\Node\Scalar\MagicConst
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
