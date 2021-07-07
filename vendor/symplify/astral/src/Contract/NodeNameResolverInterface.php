<?php

declare (strict_types=1);
namespace ConfigTransformer202107073\Symplify\Astral\Contract;

use ConfigTransformer202107073\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202107073\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202107073\PhpParser\Node $node) : ?string;
}
