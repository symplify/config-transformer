<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace ConfigTransformer202111123\Nette\Neon;

/**
 * Converts value to NEON format.
 * @internal
 */
final class Encoder
{
    /** @deprecated */
    public const BLOCK = \true;
    /** @var bool */
    public $blockMode = \false;
    /** @var string */
    public $indentation = "\t";
    /**
     * Returns the NEON representation of a value.
     */
    public function encode($val) : string
    {
        $node = $this->valueToNode($val, $this->blockMode);
        return $node->toString();
    }
    public function valueToNode($val, bool $blockMode = \false) : \ConfigTransformer202111123\Nette\Neon\Node
    {
        if ($val instanceof \DateTimeInterface) {
            return new \ConfigTransformer202111123\Nette\Neon\Node\LiteralNode($val);
        } elseif ($val instanceof \ConfigTransformer202111123\Nette\Neon\Entity && $val->value === \ConfigTransformer202111123\Nette\Neon\Neon::CHAIN) {
            $node = new \ConfigTransformer202111123\Nette\Neon\Node\EntityChainNode();
            foreach ($val->attributes as $entity) {
                $node->chain[] = $this->valueToNode($entity, $blockMode);
            }
            return $node;
        } elseif ($val instanceof \ConfigTransformer202111123\Nette\Neon\Entity) {
            return new \ConfigTransformer202111123\Nette\Neon\Node\EntityNode($this->valueToNode($val->value), $this->arrayToNodes((array) $val->attributes));
        } elseif (\is_object($val) || \is_array($val)) {
            $node = new \ConfigTransformer202111123\Nette\Neon\Node\ArrayNode($blockMode ? $this->indentation : null);
            $node->items = $this->arrayToNodes($val, $blockMode);
            return $node;
        } elseif (\is_string($val) && \ConfigTransformer202111123\Nette\Neon\Lexer::requiresDelimiters($val)) {
            return new \ConfigTransformer202111123\Nette\Neon\Node\StringNode($val);
        } else {
            return new \ConfigTransformer202111123\Nette\Neon\Node\LiteralNode($val);
        }
    }
    private function arrayToNodes($val, bool $blockMode = \false) : array
    {
        $res = [];
        $counter = 0;
        $hide = \true;
        foreach ($val as $k => $v) {
            $res[] = $item = new \ConfigTransformer202111123\Nette\Neon\Node\ArrayItemNode();
            $item->key = $hide && $k === $counter ? null : self::valueToNode($k);
            $item->value = self::valueToNode($v, $blockMode);
            if ($hide && \is_int($k)) {
                $hide = $k === $counter;
                $counter = \max($k + 1, $counter);
            }
        }
        return $res;
    }
}
