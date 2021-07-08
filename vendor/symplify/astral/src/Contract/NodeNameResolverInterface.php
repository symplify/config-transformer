<?php

declare (strict_types=1);
namespace ConfigTransformer202107080\Symplify\Astral\Contract;

use ConfigTransformer202107080\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202107080\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202107080\PhpParser\Node $node) : ?string;
}
