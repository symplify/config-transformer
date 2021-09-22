<?php

declare (strict_types=1);
namespace ConfigTransformer2021092210\PhpParser\Node\Stmt;

use ConfigTransformer2021092210\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends \ConfigTransformer2021092210\PhpParser\Node\Stmt
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
