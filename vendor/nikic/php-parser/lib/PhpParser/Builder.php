<?php

declare (strict_types=1);
namespace ConfigTransformer202110016\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer202110016\PhpParser\Node;
}
