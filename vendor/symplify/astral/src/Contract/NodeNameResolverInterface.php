<?php

declare (strict_types=1);
namespace ConfigTransformer2022022410\Symplify\Astral\Contract;

use ConfigTransformer2022022410\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022022410\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer2022022410\PhpParser\Node $node) : ?string;
}
