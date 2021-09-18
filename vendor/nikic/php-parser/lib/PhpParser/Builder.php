<?php

declare (strict_types=1);
namespace ConfigTransformer202109182\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer202109182\PhpParser\Node;
}
