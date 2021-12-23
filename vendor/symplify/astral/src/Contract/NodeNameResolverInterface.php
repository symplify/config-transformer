<?php

declare (strict_types=1);
namespace ConfigTransformer2021122310\Symplify\Astral\Contract;

use ConfigTransformer2021122310\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer2021122310\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer2021122310\PhpParser\Node $node) : ?string;
}
