<?php

declare (strict_types=1);
namespace ConfigTransformer202201173\Symplify\Astral\Contract;

use ConfigTransformer202201173\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202201173\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202201173\PhpParser\Node $node) : ?string;
}
