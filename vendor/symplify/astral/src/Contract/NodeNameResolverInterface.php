<?php

declare (strict_types=1);
namespace ConfigTransformer202112191\Symplify\Astral\Contract;

use ConfigTransformer202112191\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112191\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202112191\PhpParser\Node $node) : ?string;
}
