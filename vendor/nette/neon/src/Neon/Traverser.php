<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace ConfigTransformer2021110310\Nette\Neon;

/** @internal */
final class Traverser
{
    /** @var callable(Node): void */
    private $callback;
    /** @param  callable(Node): void  $callback */
    public function traverse(\ConfigTransformer2021110310\Nette\Neon\Node $node, callable $callback) : \ConfigTransformer2021110310\Nette\Neon\Node
    {
        $this->callback = $callback;
        return $this->traverseNode($node);
    }
    private function traverseNode(\ConfigTransformer2021110310\Nette\Neon\Node $node) : \ConfigTransformer2021110310\Nette\Neon\Node
    {
        ($this->callback)($node);
        foreach ($node->getSubNodes() as $subnode) {
            $this->traverseNode($subnode);
        }
        return $node;
    }
}
