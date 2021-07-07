<?php

declare (strict_types=1);
namespace ConfigTransformer202107072\Symplify\Astral\Contract;

use ConfigTransformer202107072\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202107072\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202107072\PhpParser\Node $node) : ?string;
}
