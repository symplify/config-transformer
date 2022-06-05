<?php

declare (strict_types=1);
namespace ConfigTransformer202206055\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer202206055\PhpParser\Node;
}
