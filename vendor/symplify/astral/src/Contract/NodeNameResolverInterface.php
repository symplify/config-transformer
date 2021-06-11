<?php

declare (strict_types=1);
namespace ConfigTransformer2021061110\Symplify\Astral\Contract;

use ConfigTransformer2021061110\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021061110\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer2021061110\PhpParser\Node $node) : ?string;
}
