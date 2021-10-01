<?php

declare (strict_types=1);
namespace ConfigTransformer202110013\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer202110013\PhpParser\Node;
}
