<?php

declare (strict_types=1);
namespace ConfigTransformer202107033\Symplify\Astral\Contract;

use ConfigTransformer202107033\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202107033\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202107033\PhpParser\Node $node) : ?string;
}
