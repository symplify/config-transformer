<?php

declare (strict_types=1);
namespace ConfigTransformer202201179\PhpParser\Node\Stmt;

use ConfigTransformer202201179\PhpParser\Node;
abstract class TraitUseAdaptation extends \ConfigTransformer202201179\PhpParser\Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
