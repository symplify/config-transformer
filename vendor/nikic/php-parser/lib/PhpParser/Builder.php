<?php

declare (strict_types=1);
namespace ConfigTransformer2022022110\PhpParser;

interface Builder
{
    /**
     * Returns the built node.
     *
     * @return Node The built node
     */
    public function getNode() : \ConfigTransformer2022022110\PhpParser\Node;
}
