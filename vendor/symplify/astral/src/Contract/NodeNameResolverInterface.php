<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\Astral\Contract;

use ConfigTransformer2022060710\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(Node $node) : bool;
    public function resolve(Node $node) : ?string;
}
