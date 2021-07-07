<?php

declare (strict_types=1);
namespace ConfigTransformer202107076\Symplify\Astral\Contract;

use ConfigTransformer202107076\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202107076\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202107076\PhpParser\Node $node) : ?string;
}
