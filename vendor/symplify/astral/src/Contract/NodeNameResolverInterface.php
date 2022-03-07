<?php

declare (strict_types=1);
namespace ConfigTransformer202203079\Symplify\Astral\Contract;

use ConfigTransformer202203079\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202203079\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202203079\PhpParser\Node $node) : ?string;
}
