<?php

declare (strict_types=1);
namespace ConfigTransformer202112236\Symplify\Astral\Contract;

use ConfigTransformer202112236\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112236\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202112236\PhpParser\Node $node) : ?string;
}
