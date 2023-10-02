<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202310\PhpParser\Node\Stmt;

use ConfigTransformerPrefix202310\PhpParser\Node;
abstract class TraitUseAdaptation extends Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
