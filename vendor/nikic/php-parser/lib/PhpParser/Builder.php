<?php

declare (strict_types=1);
namespace ConfigTransformer202204161\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer202204161\PhpParser\Node;
}
