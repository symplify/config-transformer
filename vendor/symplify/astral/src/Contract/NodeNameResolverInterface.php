<?php

declare (strict_types=1);
namespace ConfigTransformer202206079\Symplify\Astral\Contract;

use ConfigTransformer202206079\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202206079\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202206079\PhpParser\Node $node) : ?string;
}
