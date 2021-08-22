<?php

declare (strict_types=1);
namespace ConfigTransformer202108224\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer202108224\PhpParser\Node;
}
