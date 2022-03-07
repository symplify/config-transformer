<?php

declare (strict_types=1);
namespace ConfigTransformer2022030710\Symplify\Astral\Contract;

use ConfigTransformer2022030710\PhpParser\Node;
interface NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022030710\PhpParser\Node $node) : bool;
    public function resolve(\ConfigTransformer2022030710\PhpParser\Node $node) : ?string;
}
