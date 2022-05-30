<?php

declare (strict_types=1);
namespace ConfigTransformer202205306\Symplify\Astral\Contract;

use ConfigTransformer202205306\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202205306\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202205306\PhpParser\Node $node) : ?string;
}
