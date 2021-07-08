<?php

declare (strict_types=1);
namespace ConfigTransformer202107081\Symplify\Astral\Contract;

use ConfigTransformer202107081\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202107081\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202107081\PhpParser\Node $node) : ?string;
}
