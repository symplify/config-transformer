<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace ConfigTransformer202110205\Nette\Neon\Node;

use ConfigTransformer202110205\Nette\Neon\Entity;
use ConfigTransformer202110205\Nette\Neon\Node;
/** @internal */
final class EntityNode extends \ConfigTransformer202110205\Nette\Neon\Node
{
    /** @var Node */
    public $value;
    /** @var ArrayItemNode[] */
    public $attributes = [];
    public function __construct(\ConfigTransformer202110205\Nette\Neon\Node $value, array $attributes, int $startPos = null, int $endPos = null)
    {
        $this->value = $value;
        $this->attributes = $attributes;
        $this->startPos = $startPos;
        $this->endPos = $endPos ?? $startPos;
    }
    public function toValue() : \ConfigTransformer202110205\Nette\Neon\Entity
    {
        return new \ConfigTransformer202110205\Nette\Neon\Entity($this->value->toValue(), \ConfigTransformer202110205\Nette\Neon\Node\ArrayItemNode::itemsToArray($this->attributes));
    }
    public function toString() : string
    {
        return $this->value->toString() . '(' . ($this->attributes ? \ConfigTransformer202110205\Nette\Neon\Node\ArrayItemNode::itemsToInlineString($this->attributes) : '') . ')';
    }
    public function getSubNodes() : array
    {
        return \array_merge([$this->value], $this->attributes);
    }
}