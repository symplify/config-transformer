<?php

declare (strict_types=1);
namespace ConfigTransformer2022053010\Symplify\Astral\Contract;

use ConfigTransformer2022053010\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022053010\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer2022053010\PhpParser\Node $node) : ?string;
}
