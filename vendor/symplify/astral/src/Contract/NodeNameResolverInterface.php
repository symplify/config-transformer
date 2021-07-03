<?php

declare (strict_types=1);
namespace ConfigTransformer202107037\Symplify\Astral\Contract;

use ConfigTransformer202107037\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202107037\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202107037\PhpParser\Node $node) : ?string;
}
