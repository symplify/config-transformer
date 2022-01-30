<?php

declare (strict_types=1);
namespace ConfigTransformer202201306\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer202201306\PhpParser\Node;
}
