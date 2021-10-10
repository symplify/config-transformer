<?php

declare (strict_types=1);
namespace ConfigTransformer202110106\PhpParser\Node\Stmt;

use ConfigTransformer202110106\PhpParser\Node;
abstract class TraitUseAdaptation extends \ConfigTransformer202110106\PhpParser\Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
