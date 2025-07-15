<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202507\PhpParser\Node\Expr;

use ConfigTransformerPrefix202507\PhpParser\Node\ArrayItem;
use ConfigTransformerPrefix202507\PhpParser\Node\Expr;
class Array_ extends Expr
{
    // For use in "kind" attribute
    public const KIND_LONG = 1;
    // array() syntax
    public const KIND_SHORT = 2;
    // [] syntax
    /** @var ArrayItem[] Items */
    public $items;
    /**
     * Constructs an array node.
     *
     * @param ArrayItem[] $items Items of the array
     * @param array<string, mixed> $attributes Additional attributes
     */
    public function __construct(array $items = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->items = $items;
    }
    public function getSubNodeNames() : array
    {
        return ['items'];
    }
    public function getType() : string
    {
        return 'Expr_Array';
    }
}
