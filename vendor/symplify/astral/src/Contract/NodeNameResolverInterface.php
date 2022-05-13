<?php

declare (strict_types=1);
namespace ConfigTransformer202205135\Symplify\Astral\Contract;

use ConfigTransformer202205135\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202205135\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202205135\PhpParser\Node $node) : ?string;
}
