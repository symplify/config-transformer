<?php

declare (strict_types=1);
namespace ConfigTransformer202112194\PhpParser\Node;

use ConfigTransformer202112194\PhpParser\Node;
use ConfigTransformer202112194\PhpParser\NodeAbstract;
class AttributeGroup extends \ConfigTransformer202112194\PhpParser\NodeAbstract
{
    /** @var Attribute[] Attributes */
    public $attrs;
    /**
     * @param Attribute[] $attrs PHP attributes
     * @param array $attributes Additional node attributes
     */
    public function __construct(array $attrs, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->attrs = $attrs;
    }
    public function getSubNodeNames() : array
    {
        return ['attrs'];
    }
    public function getType() : string
    {
        return 'AttributeGroup';
    }
}
