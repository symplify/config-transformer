<?php

declare (strict_types=1);
namespace ConfigTransformer202203064\Symplify\Astral\Contract;

use ConfigTransformer202203064\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202203064\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202203064\PhpParser\Node $node) : ?string;
}
