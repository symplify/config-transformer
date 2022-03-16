<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\PhpParser\Builder;

use ConfigTransformer2022031610\PhpParser;
use ConfigTransformer2022031610\PhpParser\BuilderHelpers;
use ConfigTransformer2022031610\PhpParser\Node;
use ConfigTransformer2022031610\PhpParser\Node\Name;
use ConfigTransformer2022031610\PhpParser\Node\Stmt;
class Interface_ extends \ConfigTransformer2022031610\PhpParser\Builder\Declaration
{
    protected $name;
    protected $extends = [];
    protected $constants = [];
    protected $methods = [];
    /** @var Node\AttributeGroup[] */
    protected $attributeGroups = [];
    /**
     * Creates an interface builder.
     *
     * @param string $name Name of the interface
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    /**
     * Extends one or more interfaces.
     *
     * @param Name|string ...$interfaces Names of interfaces to extend
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function extend(...$interfaces)
    {
        foreach ($interfaces as $interface) {
            $this->extends[] = \ConfigTransformer2022031610\PhpParser\BuilderHelpers::normalizeName($interface);
        }
        return $this;
    }
    /**
     * Adds a statement.
     *
     * @param Stmt|PhpParser\Builder $stmt The statement to add
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addStmt($stmt)
    {
        $stmt = \ConfigTransformer2022031610\PhpParser\BuilderHelpers::normalizeNode($stmt);
        if ($stmt instanceof \ConfigTransformer2022031610\PhpParser\Node\Stmt\ClassConst) {
            $this->constants[] = $stmt;
        } elseif ($stmt instanceof \ConfigTransformer2022031610\PhpParser\Node\Stmt\ClassMethod) {
            // we erase all statements in the body of an interface method
            $stmt->stmts = null;
            $this->methods[] = $stmt;
        } else {
            throw new \LogicException(\sprintf('Unexpected node of type "%s"', $stmt->getType()));
        }
        return $this;
    }
    /**
     * Adds an attribute group.
     *
     * @param Node\Attribute|Node\AttributeGroup $attribute
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addAttribute($attribute)
    {
        $this->attributeGroups[] = \ConfigTransformer2022031610\PhpParser\BuilderHelpers::normalizeAttribute($attribute);
        return $this;
    }
    /**
     * Returns the built interface node.
     *
     * @return Stmt\Interface_ The built interface node
     */
    public function getNode() : \ConfigTransformer2022031610\PhpParser\Node
    {
        return new \ConfigTransformer2022031610\PhpParser\Node\Stmt\Interface_($this->name, ['extends' => $this->extends, 'stmts' => \array_merge($this->constants, $this->methods), 'attrGroups' => $this->attributeGroups], $this->attributes);
    }
}
