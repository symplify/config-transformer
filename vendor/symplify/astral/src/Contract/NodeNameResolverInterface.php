<?php

declare (strict_types=1);
namespace ConfigTransformer202112197\Symplify\Astral\Contract;

use ConfigTransformer202112197\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112197\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202112197\PhpParser\Node $node) : ?string;
}
