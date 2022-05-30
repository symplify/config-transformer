<?php

declare (strict_types=1);
namespace ConfigTransformer202205309\Symplify\Astral\Contract;

use ConfigTransformer202205309\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202205309\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202205309\PhpParser\Node $node) : ?string;
}
