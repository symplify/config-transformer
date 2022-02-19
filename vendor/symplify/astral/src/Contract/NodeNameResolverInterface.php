<?php

declare (strict_types=1);
namespace ConfigTransformer202202191\Symplify\Astral\Contract;

use ConfigTransformer202202191\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202202191\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202202191\PhpParser\Node $node) : ?string;
}
