<?php

declare (strict_types=1);
namespace ConfigTransformer202112118\Symplify\Astral\Contract;

use ConfigTransformer202112118\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112118\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202112118\PhpParser\Node $node) : ?string;
}
