<?php

declare (strict_types=1);
namespace ConfigTransformer202204175\Symplify\Astral\Contract;

use ConfigTransformer202204175\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202204175\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202204175\PhpParser\Node $node) : ?string;
}
