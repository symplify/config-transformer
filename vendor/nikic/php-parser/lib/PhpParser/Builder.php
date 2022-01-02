<?php

declare (strict_types=1);
namespace ConfigTransformer202201021\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer202201021\PhpParser\Node;
}
