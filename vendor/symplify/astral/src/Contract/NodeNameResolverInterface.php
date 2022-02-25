<?php

declare (strict_types=1);
namespace ConfigTransformer202202253\Symplify\Astral\Contract;

use ConfigTransformer202202253\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202253\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202202253\PhpParser\Node $node) : ?string;
}
