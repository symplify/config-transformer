<?php

declare (strict_types=1);
namespace ConfigTransformer202201094\Symplify\Astral\Contract;

use ConfigTransformer202201094\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202201094\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202201094\PhpParser\Node $node) : ?string;
}
