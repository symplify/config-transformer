<?php

declare (strict_types=1);
namespace ConfigTransformer202206056\PhpParser\Node;

use ConfigTransformer202206056\PhpParser\NodeAbstract;
class Const_ extends \ConfigTransformer202206056\PhpParser\NodeAbstract
{
    /** @var Identifier Name */
    public $name;
    /** @var Expr Value */
    public $value;
    /** @var Name|null Namespaced name (if using NameResolver) */
    public $namespacedName;
    /**
     * Constructs a const node for use in class const and const statements.
     *
     * @param string|Identifier $name       Name
     * @param Expr              $value      Value
     * @param array             $attributes Additional attributes
     */
    public function __construct($name, \ConfigTransformer202206056\PhpParser\Node\Expr $value, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = \is_string($name) ? new \ConfigTransformer202206056\PhpParser\Node\Identifier($name) : $name;
        $this->value = $value;
    }
    public function getSubNodeNames() : array
    {
        return ['name', 'value'];
    }
    public function getType() : string
    {
        return 'Const';
    }
}
