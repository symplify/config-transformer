<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\PhpParser\Node\Stmt;

use ConfigTransformer20210606\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends \ConfigTransformer20210606\PhpParser\Node\Stmt
{
    public function getSubNodeNames() : array
    {
        return [];
    }
    public function getType() : string
    {
        return 'Stmt_Nop';
    }
}
