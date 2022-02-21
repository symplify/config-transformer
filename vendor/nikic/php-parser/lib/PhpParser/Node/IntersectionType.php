<?php

declare (strict_types=1);
namespace ConfigTransformer2022022110\PhpParser\Node;

use ConfigTransformer2022022110\PhpParser\NodeAbstract;
class IntersectionType extends \ConfigTransformer2022022110\PhpParser\Node\ComplexType
{
    /** @var (Identifier|Name)[] Types */
    public $types;
    /**
     * Constructs an intersection type.
     *
     * @param (Identifier|Name)[] $types      Types
     * @param array               $attributes Additional attributes
     */
    public function __construct(array $types, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->types = $types;
    }
    public function getSubNodeNames() : array
    {
        return ['types'];
    }
    public function getType() : string
    {
        return 'IntersectionType';
    }
}
