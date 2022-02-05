<?php

declare (strict_types=1);
namespace ConfigTransformer2022020510\Symplify\Astral\Contract;

use ConfigTransformer2022020510\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022020510\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer2022020510\PhpParser\Node $node) : ?string;
}
