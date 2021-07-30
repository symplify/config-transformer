<?php

declare (strict_types=1);
namespace ConfigTransformer202107300\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer202107300\PhpParser\Node;
}
