<?php

declare (strict_types=1);
namespace ConfigTransformer202205256\Symplify\Astral\Contract;

use ConfigTransformer202205256\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202205256\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202205256\PhpParser\Node $node) : ?string;
}
