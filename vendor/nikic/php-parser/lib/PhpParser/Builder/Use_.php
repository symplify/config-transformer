<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202501\PhpParser\Builder;

use ConfigTransformerPrefix202501\PhpParser\Builder;
use ConfigTransformerPrefix202501\PhpParser\BuilderHelpers;
use ConfigTransformerPrefix202501\PhpParser\Node;
use ConfigTransformerPrefix202501\PhpParser\Node\Stmt;
class Use_ implements Builder
{
    /**
     * @var \PhpParser\Node\Name
     */
    protected $name;
    /** @var Stmt\Use_::TYPE_* */
    protected $type;
    /**
     * @var string|null
     */
    protected $alias;
    /**
     * Creates a name use (alias) builder.
     *
     * @param Node\Name|string $name Name of the entity (namespace, class, function, constant) to alias
     * @param Stmt\Use_::TYPE_* $type One of the Stmt\Use_::TYPE_* constants
     */
    public function __construct($name, int $type)
    {
        $this->name = BuilderHelpers::normalizeName($name);
        $this->type = $type;
    }
    /**
     * Sets alias for used name.
     *
     * @param string $alias Alias to use (last component of full name by default)
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function as(string $alias)
    {
        $this->alias = $alias;
        return $this;
    }
    /**
     * Returns the built node.
     *
     * @return Stmt\Use_ The built node
     */
    public function getNode() : Node
    {
        return new Stmt\Use_([new Node\UseItem($this->name, $this->alias)], $this->type);
    }
}
