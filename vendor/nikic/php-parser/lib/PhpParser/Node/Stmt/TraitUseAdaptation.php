<?php

declare (strict_types=1);
namespace ConfigTransformer202202152\PhpParser\Node\Stmt;

use ConfigTransformer202202152\PhpParser\Node;
abstract class TraitUseAdaptation extends \ConfigTransformer202202152\PhpParser\Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
