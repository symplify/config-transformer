<?php

declare (strict_types=1);
namespace ConfigTransformer202205135\PhpParser\Node;

use ConfigTransformer202205135\PhpParser\NodeAbstract;
/**
 * Represents the "..." in "foo(...)" of the first-class callable syntax.
 */
class VariadicPlaceholder extends \ConfigTransformer202205135\PhpParser\NodeAbstract
{
    /**
     * Create a variadic argument placeholder (first-class callable syntax).
     *
     * @param array $attributes Additional attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }
    public function getType() : string
    {
        return 'VariadicPlaceholder';
    }
    public function getSubNodeNames() : array
    {
        return [];
    }
}
