<?php

declare (strict_types=1);
namespace ConfigTransformer202206077\PhpParser\Node\Stmt;

use ConfigTransformer202206077\PhpParser\Node;
abstract class TraitUseAdaptation extends Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
