<?php

declare (strict_types=1);
namespace ConfigTransformer2022012510\Symplify\Astral\Contract;

use ConfigTransformer2022012510\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022012510\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer2022012510\PhpParser\Node $node) : ?string;
}
