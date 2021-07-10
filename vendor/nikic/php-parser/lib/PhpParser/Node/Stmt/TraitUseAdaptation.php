<?php

declare (strict_types=1);
namespace ConfigTransformer2021071010\PhpParser\Node\Stmt;

use ConfigTransformer2021071010\PhpParser\Node;
abstract class TraitUseAdaptation extends \ConfigTransformer2021071010\PhpParser\Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
