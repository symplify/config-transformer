<?php

declare (strict_types=1);
namespace ConfigTransformer20220608\Symplify\Astral\Contract;

use ConfigTransformer20220608\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(Node $node) : bool;
    public function resolve(Node $node) : ?string;
}
