<?php

declare (strict_types=1);
namespace ConfigTransformer202110205\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer202110205\PhpParser\Node;
}
