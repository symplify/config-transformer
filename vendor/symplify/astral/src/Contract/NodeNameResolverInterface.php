<?php

declare (strict_types=1);
namespace ConfigTransformer2022052410\Symplify\Astral\Contract;

use ConfigTransformer2022052410\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022052410\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer2022052410\PhpParser\Node $node) : ?string;
}
