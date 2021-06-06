<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\PhpParser\Node\Stmt;

use ConfigTransformer20210606\PhpParser\Node;
abstract class TraitUseAdaptation extends \ConfigTransformer20210606\PhpParser\Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
