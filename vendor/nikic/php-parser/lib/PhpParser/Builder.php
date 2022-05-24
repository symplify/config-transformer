<?php

declare (strict_types=1);
namespace ConfigTransformer2022052410\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer2022052410\PhpParser\Node;
}
