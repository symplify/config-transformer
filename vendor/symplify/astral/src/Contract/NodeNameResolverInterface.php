<?php

declare (strict_types=1);
namespace ConfigTransformer202205211\Symplify\Astral\Contract;

use ConfigTransformer202205211\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202205211\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202205211\PhpParser\Node $node) : ?string;
}
