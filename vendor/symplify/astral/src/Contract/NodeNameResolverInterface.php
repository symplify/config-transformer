<?php

declare (strict_types=1);
namespace ConfigTransformer202204039\Symplify\Astral\Contract;

use ConfigTransformer202204039\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer202204039\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer202204039\PhpParser\Node $node) : ?string;
}
