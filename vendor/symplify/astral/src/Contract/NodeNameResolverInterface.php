<?php

declare (strict_types=1);
namespace ConfigTransformer202205305\Symplify\Astral\Contract;

use ConfigTransformer202205305\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202205305\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202205305\PhpParser\Node $node) : ?string;
}
