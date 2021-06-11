<?php

declare (strict_types=1);
namespace ConfigTransformer202106110\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer202106110\PhpParser\Node;
}