<?php

declare (strict_types=1);
namespace ConfigTransformer202112316\Symplify\Astral\Contract;

use ConfigTransformer202112316\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112316\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202112316\PhpParser\Node $node) : ?string;
}
