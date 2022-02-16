<?php

declare (strict_types=1);
namespace ConfigTransformer202202161\Symplify\Astral\Contract;

use ConfigTransformer202202161\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202161\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202202161\PhpParser\Node $node) : ?string;
}
