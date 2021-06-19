<?php

declare (strict_types=1);
namespace ConfigTransformer2021061910\Symplify\Astral\Contract;

use ConfigTransformer2021061910\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021061910\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer2021061910\PhpParser\Node $node) : ?string;
}
