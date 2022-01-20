<?php

declare (strict_types=1);
namespace ConfigTransformer202201207\Symplify\Astral\Contract;

use ConfigTransformer202201207\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202201207\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202201207\PhpParser\Node $node) : ?string;
}
