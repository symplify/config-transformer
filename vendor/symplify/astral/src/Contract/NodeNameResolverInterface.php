<?php

declare (strict_types=1);
namespace ConfigTransformer202205127\Symplify\Astral\Contract;

use ConfigTransformer202205127\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202205127\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202205127\PhpParser\Node $node) : ?string;
}
