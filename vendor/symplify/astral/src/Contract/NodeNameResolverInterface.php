<?php

declare (strict_types=1);
namespace ConfigTransformer20220611\Symplify\Astral\Contract;

use ConfigTransformer20220611\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(Node $node) : bool;
    public function resolve(Node $node) : ?string;
}
