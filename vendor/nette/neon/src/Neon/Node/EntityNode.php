<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace ConfigTransformer2022041410\Nette\Neon\Node;

use ConfigTransformer2022041410\Nette\Neon\Entity;
use ConfigTransformer2022041410\Nette\Neon\Node;
/** @internal */
final class EntityNode extends \ConfigTransformer2022041410\Nette\Neon\Node
{
    /** @var Node */
    public $value;
    /** @var ArrayItemNode[] */
    public $attributes;
    public function __construct(\ConfigTransformer2022041410\Nette\Neon\Node $value, array $attributes = [])
    {
        $this->value = $value;
        $this->attributes = $attributes;
    }
    public function toValue() : \ConfigTransformer2022041410\Nette\Neon\Entity
    {
        return new \ConfigTransformer2022041410\Nette\Neon\Entity($this->value->toValue(), \ConfigTransformer2022041410\Nette\Neon\Node\ArrayItemNode::itemsToArray($this->attributes));
    }
    public function toString() : string
    {
        return $this->value->toString() . '(' . ($this->attributes ? \ConfigTransformer2022041410\Nette\Neon\Node\ArrayItemNode::itemsToInlineString($this->attributes) : '') . ')';
    }
    public function &getIterator() : \Generator
    {
        (yield $this->value);
        foreach ($this->attributes as &$item) {
            (yield $item);
        }
    }
}
