<?php

declare (strict_types=1);
namespace ConfigTransformer202112108\Symplify\Astral\Contract;

use ConfigTransformer202112108\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112108\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202112108\PhpParser\Node $node) : ?string;
}
