<?php

declare (strict_types=1);
namespace ConfigTransformer202111246\PhpParser\Node\Stmt;

use ConfigTransformer202111246\PhpParser\Node;
abstract class TraitUseAdaptation extends \ConfigTransformer202111246\PhpParser\Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
