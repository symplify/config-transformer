<?php

declare (strict_types=1);
namespace ConfigTransformer202203078\PhpParser\Node;

use ConfigTransformer202203078\PhpParser\Node;
use ConfigTransformer202203078\PhpParser\NodeAbstract;
class AttributeGroup extends \ConfigTransformer202203078\PhpParser\NodeAbstract
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
