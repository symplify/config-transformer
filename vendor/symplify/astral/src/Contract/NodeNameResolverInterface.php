<?php

declare (strict_types=1);
namespace ConfigTransformer202107039\Symplify\Astral\Contract;

use ConfigTransformer202107039\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202107039\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202107039\PhpParser\Node $node) : ?string;
}
