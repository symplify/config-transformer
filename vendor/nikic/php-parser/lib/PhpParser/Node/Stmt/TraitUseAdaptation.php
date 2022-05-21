<?php

declare (strict_types=1);
namespace ConfigTransformer202205214\PhpParser\Node\Stmt;

use ConfigTransformer202205214\PhpParser\Node;
abstract class TraitUseAdaptation extends \ConfigTransformer202205214\PhpParser\Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
