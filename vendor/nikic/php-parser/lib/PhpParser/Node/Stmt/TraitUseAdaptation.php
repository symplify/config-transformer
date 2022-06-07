<?php

declare (strict_types=1);
namespace ConfigTransformer202206076\PhpParser\Node\Stmt;

use ConfigTransformer202206076\PhpParser\Node;
abstract class TraitUseAdaptation extends \ConfigTransformer202206076\PhpParser\Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
