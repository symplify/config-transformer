<?php

declare (strict_types=1);
namespace ConfigTransformer202201152\Symplify\Astral\Contract;

use ConfigTransformer202201152\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202201152\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202201152\PhpParser\Node $node) : ?string;
}
