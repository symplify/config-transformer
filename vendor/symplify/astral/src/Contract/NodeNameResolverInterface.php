<?php

declare (strict_types=1);
namespace ConfigTransformer202107050\Symplify\Astral\Contract;

use ConfigTransformer202107050\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202107050\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202107050\PhpParser\Node $node) : ?string;
}
